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

	static function formatNumber($number) {
		if ($number < 0) $minus = true;
		$number = abs($number);

		while (strlen($number) > 3) {
			$new_number = '.' . substr($number, strlen($number) - 3, 3) . $new_number;
			$number = substr($number, 0, strlen($number) - 3);
		}

		if ($minus)return '-'. $number . $new_number;
		return $number . $new_number;
	}
}
