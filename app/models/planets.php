<?php
/**
 * Planets - backend for planets
 *
 * GPL
 */

class Planets {
	static function getList($user_id) {
		return DBManager::get()->query("SELECT * FROM lis_planets
			WHERE owner_id = '$user_id'")->fetchAll(PDO::FETCH_ASSOC);
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
		return DBManager::get()->query("SELECT * FROM lis_planets_buildings
			LEFT JOIN lis_buildings USING (building_id)
			WHERE planet_id = $planet_id")->fetchAll(PDO::FETCH_ASSOC);
	}
}
