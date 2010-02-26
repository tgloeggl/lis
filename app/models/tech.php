<?php
/**
 * Tech Model - get lists of research technologies and researchs
 *
 * GPL
 */

class Tech {
	static function getDrives() {
		return DBManager::get()->query("SELECT * FROM lis_drives
			WHERE 1
			ORDER BY speed ASC")->fetchAll();
	}

	static function getModules() {
		return DBManager::get()->query("SELECT * FROM lis_modules
			WHERE 1
			ORDER BY name ASC, credits ASC")->fetchAll();
	}

	static function getShipsizes() {
		return DBManager::get()->query("SELECT * FROM lis_shipsizes
			WHERE 1
			ORDER BY tonnage ASC")->fetchAll();
	}
}
