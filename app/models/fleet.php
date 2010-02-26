<?php
/**
 * Fleet
 *
 * GPL
 */
 
class Fleet {
	static function getFleets($user_id) {
	
	}
	
	static function getShips($fleet_id) {
	
	}

	static function getShipdesigns($user_id = false) {
		if (!$user_id) $user_id = Login::getUserID();

		$ship_design = DBManager::get()->query("SELECT * FROM lis_shipdesign
			WHERE owner_id = $user_id")->fetchAll(PDO::FETCH_ASSOC);

		foreach ($ship_design as $key => $design) {
			$ship_design[$key]['modules'] = DBManager::get()->query("SELECT * FROM lis_shipdesign_modules
					LEFT JOIN lis_modules USING (module_id)
				WHERE shipdesign_id = ". $design['shipdesign_id'])->fetchAll(PDO::FETCH_ASSOC);

			$ship_design[$key]['drive'] = DBManager::get()->query("SELECT * FROM lis_drives
				WHERE drive_id = ". $design['drive_id'])->fetch(PDO::FETCH_ASSOC);

			$ship_design[$key]['size'] = DBManager::get()->query("SELECT * FROM lis_shipsizes
				WHERE shipsize_id = ". $design['drive_id'])->fetch(PDO::FETCH_ASSOC);


			foreach ($ship_design[$key]['modules'] as $module) {
				for ($i = $module['range']; $i > 0; $i--) {
					$ship_design[$key]['damage'][$i] += ($module['attack'] * $module['count']);
				}
			}

			$max_dmg = 0;
			foreach ((array)$ship_design[$key]['damage'] as $dmg) {
				$max_dmg = max($dmg, $max_dmg);
			}
			$ship_design[$key]['max_damage'] = $max_dmg;
		}

		return $ship_design;
	}

	static function createDesign($name, $modules, $size, $drive, $res, $armor, $cargo) {
		$stmt = DBManager::get()->prepare("INSERT INTO lis_shipdesign
			(owner_id, name, shipsize_id, drive_id, armor, cargo, carboxin, detrogen, radium, credits)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->execute(array(Login::getUserID(), $name, $size['shipsize_id'], $drive['drive_id'],
			$armor, $cargo, $res['carboxin'], $res['detrogen'], $res['radium'], $res['credits']));

		$shipdesign_id = DBManager::get()->lastInsertId();

		$stmt = DBManager::get()->prepare("INSERT INTO lis_shipdesign_modules
			(shipdesign_id, module_id, count)
			VALUES (?, ?, ?)");

		foreach ($modules as $module_id => $count) {
			if ($count > 0) {
				$stmt->execute(array($shipdesign_id, $module_id, $count));
			}
		}
	}

	function deleteDesign($design_id) {
		$user_id = Login::getUserID();
		DBManager::get()->query("DELETE FROM lis_shipdesign
			WHERE shipdesign_id = $design_id AND owner_id = $user_id");
	}
}
