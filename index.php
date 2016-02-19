<?php
/*
 * Sippy v0.1.0
 */

/**
 * Check your PHP environment below - uncomment
 */
// if (phpversion() >= '5.3'){echo 'You may run Sippy fine';}else{echo 'You CANNOT run Sippy, upgrade to PHP 5.3+';}

define('ERRCONTROL', 'development');

switch (ERRCONTROL) {

	case 'development':
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	break;
	case 'production':
		ini_set('display_errors', 0);
	break;
	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Error control environment not set up correctly.';
		exit(1); // EXIT_ERROR
}

//Start the Session
session_start(); 

// Defines
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('APP_DIR', ROOT_DIR .'application/');


// Includes
require(APP_DIR .'config/config.php');
require(ROOT_DIR .'system/hook.php');
require(ROOT_DIR .'system/model.php');
require(ROOT_DIR .'system/view.php');
require(ROOT_DIR .'system/controller.php');
require(ROOT_DIR .'system/sippy.php');
require(ROOT_DIR .'system/log.php');

//load hook class
$hook = new Sippy_hook($config['activate_hooks']);

global $config,$hook;

//pre system hook
$hook->call_hook('before_system');
// Define base URL
define('BASE_URL', $config['base_url']);
sippy();

