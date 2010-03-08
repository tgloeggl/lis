<?php
/**
 * Planets - backend for planets
 *
 * GPL
 */

class Planets {
	static function getList($user_id) {
		return DBManager::get()->query("SELECT *,

				(SELECT SUM(b.mod_carboxin * pb.level) FROM lis_planets_buildings pb
				 LEFT JOIN lis_buildings b USING (building_id)
				 WHERE planet_id = lp.planet_id AND pb.active = 1) as pcarboxin,

				(SELECT SUM(b.mod_detrogen * pb.level) FROM lis_planets_buildings pb
				 LEFT JOIN lis_buildings b USING (building_id)
				 WHERE planet_id = lp.planet_id AND pb.active = 1) as pdetrogen,

				(SELECT SUM(b.mod_radium * pb.level) FROM lis_planets_buildings pb
				 LEFT JOIN lis_buildings b USING (building_id)
				 WHERE planet_id = lp.planet_id AND pb.active = 1) as pradium,

				(SELECT SUM(b.mod_credits * pb.level) FROM lis_planets_buildings pb
				 LEFT JOIN lis_buildings b USING (building_id)
				 WHERE planet_id = lp.planet_id AND pb.active = 1) as pcredits

			FROM lis_planets lp
			WHERE owner_id = '$user_id'")->fetchAll(PDO::FETCH_ASSOC);
	}

	static function getShortList($user_id) {
		return DBManager::get()->query("SELECT * FROM lis_planets
			WHERE owner_id = $user_id
			ORDER BY size DESC, type DESC")->fetchAll(PDO::FETCH_ASSOC);
	}

	static function getClass($temp, $type) {
		$class = array (
			'poor'   => array('sun' => 'S', 'torrid' => 'Y', 'hot' => 'T', 'normal' => 'T', 'cold' => 'T', 'freezing' => 'Y', 'zero' => 'Y'),
			'few'    => array('sun' => 'Y', 'torrid' => 'Y', 'hot' => 'T', 'normal' => 'F', 'cold' => 'T', 'freezing' => 'T', 'zero' => 'Y'),
			'casual' => array('sun' => 'Y', 'torrid' => 'T', 'hot' => 'F', 'normal' => 'H', 'cold' => 'F', 'freezing' => 'T', 'zero' => 'T'),
			'normal' => array('sun' => 'T', 'torrid' => 'F', 'hot' => 'H', 'normal' => 'J', 'cold' => 'H', 'freezing' => 'F', 'zero' => 'T'),
			'gaia'   => array('sun' => 'F', 'torrid' => 'H', 'hot' => 'J', 'normal' => 'M', 'cold' => 'J', 'freezing' => 'H', 'zero' => 'F'),
		);

		return $class[$type][self::getTempType($temp)] ? $class[$type][self::getTempType($temp)] : 'X';
	}

	static function getClassName($temp, $type) {
		$class = self::getClass($temp, $type);
		$classes = array (
			'M' => 'erdähnlich',
			'J' => 'normal',
			'H' => 'akzeptabel',
			'F' => 'armselig',
			'T' => 'unwirtlich',
			'Y' => 'unbewohnbar',
			'S' => 'Sonne',
			'X' => 'nicht klassifiziert'
		);

		return $classes[$class];
	}

	static function getTypeName($type) {
		$types = array(
			'poor'   => 'kaum',
			'few'    => 'wenige',
			'casual' => 'gelegentliche',
			'normal' => 'normale',
			'gaia'   => 'reichhaltige'
		);

		return $types[$type];
	}

	static function getTempType($temp) {
		if ($temp > 2000) {
			return 'sun';
		} else if ($temp > 100) {
			return 'torrid';
		} else if ($temp > 50) {
			return 'hot';
		} else if ($temp > -20) {
			return 'normal';
		} else if ($temp > -80) {
			return 'freezing';
		} else {
			return 'zero';
		}
	}

	static function getTempName($temp) {
		$temps = array(
			'sun'      => 'sonnengleich',
			'torrid'   => 'sengend heiß',
			'hot'      => 'heiß',
			'normal'   => 'normal',
			'cold'     => 'kalt',
			'freezing' => 'eiskalt',
			'zero'     => 'extrem kalt',
		);


		return $temps[self::getTempType($temp)];
	}

	static function getSizeName($size) {
		if ($size > 90) {
			return 'riesig';
		} else if ($size >= 65) {
			return 'groß';
		} else if ($size >= 40) {
			return 'normal groß';
		} else if ($size >= 20) {
			return 'klein';
		} else {
			return 'winzig';
		}
	}

	static function is_blocked($planet_id) {
		$data = DBManager::get()->query("SELECT x, y, owner_id FROM lis_planets
			WHERE planet_id = $planet_id")->fetch();

		return DBManager::get()->query("SELECT COUNT(*) FROM lis_user_fleets
			WHERE x = ". $data['x'] . " AND y = ". $data['y'] ." 
				AND owner_id != ". $data['owner_id'])->fetchColumn() ? true : false;
	}

	static function getBuildings($planet_id) {
		return DBManager::get()->query("SELECT lb.*, lpb.planet_id, lpb.level, lpb.active FROM lis_buildings lb
			LEFT JOIN lis_planets_buildings lpb ON (lb.building_id = lpb.building_id AND lpb.planet_id = $planet_id)
			LEFT JOIN lis_research lr USING (research_id)
			WHERE research_id = 0 OR lr.name IS NOT NULL
			ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
	}
	
	static function getEnergy($planet_id) {
		// every planet generates 200 MWh on its own
		return DBManager::get()->query("SELECT SUM(lbp.level * lb.mod_energy) FROM lis_planets_buildings lbp
			LEFT JOIN lis_buildings lb USING (building_id)
			WHERE active = 1 AND planet_id = $planet_id")->fetchColumn() + 200;
	}
	
	static function build($planet_id, $building_id, &$messages) {
		$planet   = DBManager::get()->query("SELECT * FROM lis_planets WHERE planet_id = $planet_id")->fetch();
		$building = DBManager::get()->query("SELECT * FROM lis_buildings WHERE building_id = $building_id")->fetch();
		
		// check, if building is already beeing built on this planet
		if (Functions::checkEvent('build', $planet_id, $building_id)) {
			$messages = MessageBox::error('Es wird bereits ein Gebäude dieses Typs errichtet!');
			return false;
		}
		
		// check, if the maximum buildable level has been reached
		$current_level = DBManager::get()->query("SELECT level FROM lis_planets_buildings 
			WHERE planet_id = $planet_id AND building_id = $building_id")->fetchColumn();
			
		if ($current_level >= $building['max_level']) {
			$messages = MessageBox::error('Sie können kein weiteres Gebäude dieser Art errichten!');
			return false;
		}
		
		foreach (Config::get('resources') as $res) {
			if ($res != 'energy') {
				if ($building[$res] > $planet[$res]) {
					$messages = MessageBox::error('Nicht genügend Ressourcen, um dieses Gebäude zu errichten!');
					return false;
				}
				$new_resources[] = $res .' = ' . ($planet[$res] - $building[$res]);
			}
		}
		
		// insert event to be ticked		
		Functions::insertEvent('build', $planet_id, $building_id, $building['completion']);
		
		// remove resources from planet
		DBManager::get()->query("UPDATE lis_planets SET ". implode(', ', $new_resources)
			. " WHERE planet_id = $planet_id");

		$messages = MessageBox::success('Gebäude wird errichtet!');
		
		return true;
	}
	
	static function deactivateBuildingsByUsage($usage, $planet_id) {
		DBManager::get()->query("UPDATE lis_planets_buildings lp
			LEFT JOIN lis_buildings b USING (building_id)
			SET active = 0
			WHERE b.mod_$usage < 0 AND lp.planet_id = $planet_id");
	}
	
	static function activated($planet_id, $building_id) {
		$db = DBManager::get()->query("SELECT active FROM lis_planets_buildings
			WHERE building_id = $building_id AND planet_id = $planet_id");
		
		// if there exists no entry for this planet and building, building cannot be deactivated
		if (!$data = $db->fetch()) {
			return true;
		}
		
		return $data['active'] ? true : false;
	}
	
	static function setActivation($activate, $planet_id, $building_id) {		
		DBManager::get()->query("UPDATE lis_planets_buildings
			SET active = ". (($activate) ? '1' : '0') ."
			WHERE planet_id = $planet_id AND building_id = $building_id");
	}

	static function getStorage($planet_id) {
		$storage = DBManager::get()->query("SELECT SUM(b.mod_storage * pb.level) FROM lis_planets_buildings pb
			LEFT JOIN lis_buildings b USING (building_id)
			WHERE planet_id = $planet_id AND pb.active = 1")->fetchColumn();

		// every planet has a basic storage capacity of 5000 units
		$storage += 5000;

		return array('carboxin' => $storage, 'detrogen' => $storage, 'radium' => $storage, 'credits' => $storage * 10);
	}
}
