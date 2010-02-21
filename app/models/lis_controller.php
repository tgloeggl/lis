<?php

/**
 * a controller showing embedding the output into html
 *
 * GPL
 */

class LIS_Controller extends Trails_Controller {
	function before_filter($action, $args) {
		$this->flash = Trails_Flash::instance();
	}

}
