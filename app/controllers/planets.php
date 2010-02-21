<?php
/**
 * Planets - overview, build-actions, etc.
 *
 * GPL
 */
class PlanetsController extends LIS_Controller {
	function index_action() {
		$this->planets = Planets::getList(Login::getUserID());
	}

	function details_action($planet_id) {
		$current_planet = false;

		$planets = Planets::getList(Login::getUserID());
		foreach ($planets as $planet) {
			if ($planet['planet_id'] == $planet_id) $current_planet = $planet;
		}

		if (!$current_planet) throw new Exception('Dieser Planet gehört nicht dir!');

		$this->planet    = $current_planet;
		$this->buildings = Planets::getBuildings($planet_id);
	}
}
