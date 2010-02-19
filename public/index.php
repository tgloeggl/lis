<?php
/**
 * index.php - the dispatcher for the trails-framework
 *
 * GPL
 */

// header
header('Content-Type: text/html; charset=iso-8859-1');

// set PHP_SELF correctly
$PHP_SELF = $_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];

// define root and trails uri
$trails_root = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . Config::get('trails_path');
$trails_uri = Config::get('web_path') . '/index.php';

// dispatch
$request_uri = 
	$_SERVER['REQUEST_URI'] === $_SERVER['PHP_SELF']
  ? '/' 
	: substr($_SERVER['REQUEST_URI'], strlen($_SERVER['PHP_SELF']));

$default_controller = 'default';

// var_dump($_SERVER['REQUEST_URI'], $_SERVER['PHP_SELF'], $request_uri);
$dispatcher = new Trails_Dispatcher($trails_root, $trails_uri,
																		$default_controller);
$dispatcher->dispatch($request_uri);
