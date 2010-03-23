<?php
/**
 * Map
 *
 * GPL
 */
 
class Map {
	static function getData($x, $y, $spread = 20) {
		$db = DBManager::get()->query("SELECT * FROM lis_planets
			WHERE x > $x - $spread AND x < $x + $spread
				AND y > $y - $spread AND y < $y + $spread");

		while ($data = $db->fetch(PDO::FETCH_ASSOC)) {
			$ret[$data['x']][$data['y']] = $data;
		}

		$db = DBManager::get()->query("SELECT * FROM lis_map_elements
			WHERE x > $x - $spread AND x < $x + $spread
				AND y > $y - $spread AND y < $y + $spread");

		while ($data = $db->fetch(PDO::FETCH_ASSOC)) {
			$ret[$data['x']][$data['y']] = $data;
		}

		return $ret;
	}
	
}
