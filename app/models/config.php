<?php

/**
 * config.php - get configuration-options
 *
 * GPL
 */

class Config {
	static function set($variable, $value) {
		$GLOBALS['_config'][$variable] = $value;
	}

	static function get($variable) {
		return $GLOBALS['_config'][$variable];
	}
}
