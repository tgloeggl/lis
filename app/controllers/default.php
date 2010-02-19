<?php

class DefaultController extends LIS_Controller {
	function index_action() {
		/* * * * * * * * * * * * * * * * * * * * * * * * *
		 * * *   L I N K B A R   A N D   I C O N S   * * *
	   * * * * * * * * * * * * * * * * * * * * * * * * */
		$menu[] = array( 'name' => 'Planeten (0.1)', 'page' => 'planets', 'target' => 'main');
		$menu[] = array( 'name' => 'Flotte (0.1)', 'page' => 'fleet', 'target' => 'main');
		$menu[] = array( 'name' => 'Offiziere (0.3)', 'page' => 'officers', 'target' => 'main');
		$menu[] = array( 'name' => 'Karte (0.1)', 'page' => 'map', 'target' => 'main');
		$menu[] = array( 'name' => 'Forschung (0.3)', 'page' => 'research', 'target' => 'main');
		$menu[] = array( 'name' => 'Diplomatie (0.4)', 'page' => 'alliance', 'target' => 'main');
		$menu[] = array( 'name' => 'Spieler (0.2)', 'page' => 'ranking', 'target' => 'main');
		$menu[] = array( 'name' => 'Logout (0.1)', 'page' => 'logout', 'target' => '_top');

		$icons[] = array( 'name' => 'Profil (0.2)', 'page' => 'options', 'target' => 'main', 'image' => 'icons/profile.png');
		$icons[] = array( 'name' => 'Hilfe (0.5)', 'page' => 'help', 'target' => 'main', 'image' => 'icons/help.png');
		$icons[] = array( 'name' => 'Nachrichten (0.2)', 'page' => 'messaging', 'params' => '?cat=sys', 'target' => 'main', 'image' => 'icons/mail.png');

		$this->menu = $menu;
		$this->icons = $icons;

    $factory = new Flexi_TemplateFactory($GLOBALS['BASE_PATH'] . DIRECTORY_SEPARATOR . 'templates');
    $this->set_layout($factory->open('layouts/main')); 

		$this->stat = array(
			'players' => '0',
			'online'  => '0',
			'planets' => '0',
			'version' => Config::get('version'),
		);

		if (!LoginModel::ok()) {
			$this->redirect('default/login');
		}

	}

	function login_action() {
		$this->message = $this->flash['message'];

    $factory = new Flexi_TemplateFactory($GLOBALS['BASE_PATH'] . DIRECTORY_SEPARATOR . 'templates');
    $this->set_layout($factory->open('layouts/main')); 
	}

	function dologin_action($username, $password_md5) {
		if (LoginModel::check($username, $password_md5)) {
			$this->redirect('default/index');
		} 

		$this->flash['message'] = MessageBox::error('Logindaten nicht korrekt!');
		$this->redirect('default/login');
	}

	function newaccount_action() {
    $factory = new Flexi_TemplateFactory($GLOBALS['BASE_PATH'] . DIRECTORY_SEPARATOR . 'templates');
    $this->set_layout($factory->open('layouts/main')); 

	}

	function changelog_action() { }

}
