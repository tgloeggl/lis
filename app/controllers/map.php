<?php
/**
 * map controller
 *
 * GPL
 */

class MapController extends LIS_Controller {
	function index_action($x = false, $y = false) {
		if ($x === false || $y === false) {
			$planets = Planets::getShortList(Login::getUserID());
			$x = $planets[0]['x'];
			$y = $planets[0]['y'];
		}
	}
}
