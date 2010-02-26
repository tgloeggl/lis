<?php
/**
 * design controller - Shipdesigns
 *
 * GPL
 */

class DesignController extends LIS_Controller {
	function index_action() {
		$this->ship_designs = Fleet::getShipDesigns();
	}

	function new_action() {
		if ($this->flash['message']) $this->message = $this->flash['message'];

		$this->drives  = Tech::getDrives();
		$this->sizes   = Tech::getShipsizes();
		$this->modules = Tech::getModules();
	}

	function delete_action($design_id) {
		Fleet::deleteDesign($design_id);

		$this->redirect('design/index');
	}

	function create_action() {
		// get all available drives, sizes, and modules
		$drives  = Tech::getDrives();
		$sizes   = Tech::getShipsizes();
		$modules = Tech::getModules();

		// get the ships configuration
		$sd_modules = Request::get('modules');
		$sd_size    = Request::get('size');
		$sd_drive   = Request::get('drive');
		$sd_name    = Request::get('ship_name');

		// check, if a proper name is given
		if (!$sd_name) {
			$this->flash['message'] = MessageBox::error('Sie haben dem Schiffstyp keinen Namen gegeben!');
			$this->redirect('design/new');
			return;
		}

		// initialize variables
		$build_modules = array();
		$build_weight  = 0;
		$build_size    = null;
		$build_res     = array();
		$build_drive   = null;
		$build_armor   = 0;
		$build_cargo   = 0;

		// only allow modules already available
		foreach($modules as $module) {
			$build_modules[$module['module_id']] = $sd_modules[$module['module_id']] ? $sd_modules[$module['module_id']] : 0;
			$build_weight += $sd_modules[$module['module_id']] * $module['weight'];
			$build_armor  += $sd_modules[$module['module_id']] * $module['armor'];
			$build_cargo  += $sd_modules[$module['module_id']] * $module['cargo'];
			foreach (Config::get('resources') as $res) {
				if ($res != 'energy') {
					$build_res[$res] += ($module[$res] * $sd_modules[$module['module_id']]);
				}
			}
		}

		// check the shipsize and the weight
		foreach ($sizes as $size) {
			if ($sd_size == $size['shipsize_id']) {
				if ($build_weight > $size['tonnage']) {
					$this->flash['message'] = MessageBox::error('Das Schiff ist zu schwer!');
					$this->redirect('design/new');
					return;
				}
				$build_size = $size;

				$build_armor += $size['armor'];
				foreach (Config::get('resources') as $res) {
					if ($res != 'energy') {
						$build_res[$res] += $size[$res];
					}
				}

			}
		}

		if (!is_array($build_size)) {
			$this->flash['message'] = MessageBox::error('Sie haben einen unbekannten Schiffstyp gewählt!');
			$this->redirect('design/new');
			return;
		}

		// check the drive
		foreach ($drives as $drive) {
			if ($sd_drive == $drive['drive_id']) {
				$build_drive = $drive;
			}
		}

		if (!is_array($build_drive)) {
			$this->flash['message'] = MessageBox::error('Sie haben einen unbekannten Antrieb gewählt!');
			$this->redirect('design/new');
			return;
		}

		// finally, store the shipdesign
		Fleet::createDesign($sd_name, $build_modules, $build_size, $build_drive, $build_res, $build_armor, $build_cargo);
	}
}
