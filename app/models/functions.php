<?php
/**
 * functions encapsulated in a functions class
 *
 * GPL
 */

class Functions {
	static function getStats() {
		$ret = array (
			'players' => DBManager::get()->query("SELECT COUNT(*) FROM lis_user")->fetchColumn(),
			'online'  => DBManager::get()->query("SELECT COUNT(*) FROM lis_user
				WHERE lifesign > (UNIX_TIMESTAMP(NOW()) - 60)")->fetchColumn(),
			'planets' => DBManager::get()->query("SELECT COUNT(*) FROM lis_planets")->fetchColumn(),
			'version' => Config::get('version'),
		);

		return $ret;
	}

	static function formatNumber($number, $color = false) {
		if ($number < 0) $minus = true;
		$number = abs($number);

		while (strlen($number) > 3) {
			$new_number = '.' . substr($number, strlen($number) - 3, 3) . $new_number;
			$number = substr($number, 0, strlen($number) - 3);
		}

		
		$number .= $new_number;

		if ($color) {
			if ($minus) {
				return '<span class="red">- '. $number .'</span>';
			} else {
				return '<span class="green">+ '. $number .'</span>';
			}
		} else {
			if ($minus) return '-'. $number;
			return $number;
		}
	}
	
	static function insertEvent($type, $range_id, $sec_range_id, $finish) {
		$user_id = Login::getUserID();
		return DBManager::get()->query("INSERT INTO lis_events 
			(type, user_id, range_id, sec_range_id, start, end)
			VALUES ('$type', $user_id, $range_id, $sec_range_id, 
				UNIX_TIMESTAMP(NOW()), " . (time() + $finish) .')');
	}
	
	static function checkEvent($type, $range_id, $sec_range_id) {		
		return DBManager::get()->query("SELECT * FROM lis_events
			WHERE type = '$type' AND range_id = $range_id AND sec_range_id = $sec_range_id")->fetch();
	}
	
	static function getEvents($type, $range_id, $user_id = false) {
		if (!$user_id) $user_id = Login::getUserID();
		$db = DBManager::get()->query("SELECT * FROM lis_events
			WHERE range_id = $range_id AND type = '$type' AND user_id = $user_id");
		
		while ($data = $db->fetch()) {			
			$ret[$data['sec_range_id']] = $data;
		}
		
		return $ret;
	}	
}
