<?php
/**
 * Request-class for getting request-parameters
 * 
 * GPL
 */

class Request {
	/**
	 * returns a request-variable
	 *
	 */
	function get( $variable, $default = null ) {
		if ($_REQUEST[$variable]) {
			return $_REQUEST[$variable];
		}

		return $default;
	}
}
