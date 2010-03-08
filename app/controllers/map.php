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

		$this->map = Map::getData($x, $y, 8);
		$this->x = $x;
		$this->y = $y;
	}

	function mapdata_action($x, $y) {
		$map = Map::getData($x, $y, 8);

		for ($i = $y - 7; $i < $y + 7; $i++) {
			for ($j = $x - 7; $j < $x + 7; $j++) {
				if ($map[$j][$i]['planet_id']) {
					echo Assets::img('planets/'. Planets::getClass($map[$j][$i]['temp'], $map[$j][$i]['type']));
				}
				echo '|';
			}
		}

		die;
	}
}
