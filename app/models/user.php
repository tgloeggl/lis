<?php
/**
 * User
 *
 * GPL
 */
 
class User {
	static function getName($user_id) {
		static $names;

		if (!$names[$user_id]) {
			$names[$user_id] = DBManager::get()->query("SELECT username FROM lis_user
				WHERE user_id = $user_id")->fetchColumn();
		}

		return $names[$user_id];
	}
	
}
