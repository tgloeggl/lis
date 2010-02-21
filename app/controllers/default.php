<?php
/**
 * portal
 *
 * GPL
 */
class DefaultController extends LIS_Controller {
	function index_action() {
		if ($this->flash['message']) $this->message = $this->flash['message'];
		if ($this->flash['username']) $this->username = htmlspecialchars($this->flash['username']);

		// check, if current user is logged in
		if (!Login::ok()) {
			$this->login_necessary = true;
		} else {
			$menu[] = array( 'name' => 'Planeten (0.1)',   'page' => 'planets');
			$menu[] = array( 'name' => 'Flotte (0.1)',     'page' => 'fleet');
			$menu[] = array( 'name' => 'Offiziere (0.3)',  'page' => 'officers');
			$menu[] = array( 'name' => 'Karte (0.1)',      'page' => 'map');
			$menu[] = array( 'name' => 'Forschung (0.3)',  'page' => 'research');
			$menu[] = array( 'name' => 'Diplomatie (0.4)', 'page' => 'alliance');
			$menu[] = array( 'name' => 'Spieler (0.2)',    'page' => 'ranking');
			$menu[] = array( 'name' => 'Logout (0.1)',     'page' => 'default', 'action' => 'logout', 'nojs' => true);

			$icons[] = array( 'name' => 'Profil (0.2)', 'page' => 'options', 'target' => 'main', 'image' => 'icons/profile.png');
			$icons[] = array( 'name' => 'Hilfe (0.5)', 'page' => 'help', 'target' => 'main', 'image' => 'icons/help.png');
			$icons[] = array( 'name' => 'Nachrichten (0.2)', 'page' => 'messaging', 'params' => '?cat=sys', 'target' => 'main', 'image' => 'icons/mail.png');

			$this->menu = $menu;
			$this->icons = $icons;

		}

 	  $factory = new Flexi_TemplateFactory($GLOBALS['BASE_PATH'] . DIRECTORY_SEPARATOR . 'templates');
    $this->set_layout($factory->open('layouts/main')); 

		$this->stat = Functions::getStats();
	}


	function login_action($username, $password_md5) {
		if (Login::check($username, $password_md5)) {
			$this->redirect('default/index');
		} else {
			$this->flash['message'] = MessageBox::error('Logindaten nicht korrekt!');
			$this->flash['username'] = $username;
			$this->redirect('default/index');
		}
	}

	function logout_action() {
		Login::logout();
		$this->redirect('default/index');
	}

	function newaccount_action() {
    $factory = new Flexi_TemplateFactory($GLOBALS['BASE_PATH'] . DIRECTORY_SEPARATOR . 'templates');
    $this->set_layout($factory->open('layouts/main')); 

	}

	function changelog_action() { }

}
