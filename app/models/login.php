<?php
/**
 * Login - backend for login
 *
 * GPL
 */

class Login {
	static function ok() {
		return $_SESSION['authenticated'] ? true : false;
	}

	static function getUsername() {
		return $_SESSION['authenticated']['username'];
	}

	static function getUserID() {
		return $_SESSION['authenticated']['user_id'];
	}

	static function check($username, $password_md5) {
		$stmt = DBManager::get()->prepare("SELECT * FROM lis_user 
			WHERE username = ? AND password = ?");
		$stmt->execute(array($username, $password_md5));

		if ($data = $stmt->fetch()) {
			session_register('authenticated');
			$_SESSION['authenticated'] = array (
				'username' => $data['username'],
				'user_id'  => $data['user_id']
			);
			return true;
		}

		return false;
	}

	static function logout() {
		$_SESSION['authenticated'] = false;
	}
}
