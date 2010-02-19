<?php
/**
 * LoginModel - backend for login
 *
 * GPL
 */

class LoginModel {
	static function ok() {
		return $_SESSION['authenticated'] ? true : false;
	}

	static function check($username, $password_md5) {
		$stmt = DBManager::get()->prepare("SELECT * FROM lis_user 
			WHERE username = ? AND password = ?");
		$stmt->execute(array($username, $password_md5));

		if ($stmt->fetch()) {
			session_register('authenticated');
			$_SESSION['authenticated'] = true;
			return true;
		}

		return false;
	}
}
