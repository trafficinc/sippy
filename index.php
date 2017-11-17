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
		exit(1);
}

//Start the Session
session_start(); 

// Defines
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('APP_DIR', ROOT_DIR .'application/');
define('VIEWS_DIR', ROOT_DIR .'application/views/');


// Includes
function autoloadum($class) {
    $leaveOut = array('Validation');
    if (! in_array($class, $leaveOut)) {
        include ROOT_DIR ."system/".$class.".php";
    }
}
spl_autoload_register("autoloadum");
//Load helper functions
require(ROOT_DIR .'system/helpf.php');

$config = load_config();

//load hook class
$hook = new Sippy_hook($config['activate_hooks']);
//pre system hook
$hook->call_hook('before_system');
$sippy = new Sippy($config,$hook);
