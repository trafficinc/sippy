<?php
defined('ROOT_DIR') OR exit('No direct script access allowed');

require_once(ROOT_DIR .'system/env.php');
sippy_load_env(ROOT_DIR .'.env');

// Base URL including trailing slash (e.g. http://localhost/)
$config['base_url'] = sippy_env('BASE_URL', '');
// Default controller to load
$config['default_controller'] = sippy_env('DEFAULT_CONTROLLER', 'Main');
// Controller used for errors (e.g. 404, 500 etc)
$config['error_controller'] = sippy_env('ERROR_CONTROLLER', 'Errors');
//Activate Hooks? TRUE/FALSE
$config['activate_hooks'] = sippy_env('ACTIVATE_HOOKS', false);
//Activate Logs? TRUE/FALSE
$config['activate_logs'] = sippy_env('ACTIVATE_LOGS', false);
//Log Path, set to 'logs/' :: logs DIR
$config['log_path'] = sippy_env('LOG_PATH', 'logs/');
$config['charset'] = sippy_env('CHARSET', 'UTF-8');

//MySql Port
//many systems default to port 3306
$config['mysql_port'] = sippy_env('MYSQL_PORT', 8889) ?: 8889;
// Database host (e.g. localhost)
$config['db_host'] = sippy_env('DB_HOST', 'localhost');
// Database name
$config['db_name'] = sippy_env('DB_NAME', '');
// Database username
$config['db_username'] = sippy_env('DB_USERNAME', '');
// Database password
$config['db_password'] = sippy_env('DB_PASSWORD', '');
