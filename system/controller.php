<?php

class Sippy_controller {

	public $base_url;
	private $logger;

	public function __construct() {
		global $config;
		$this->base_url = $config;

		$log = new Sippy_log($config['activate_logs']);
		$this->logger = $log;
	}
	
	public function Model($name) {
		require(APP_DIR .'models/'. strtolower($name) .'.php');

		$model = new $name;
		return $model;
	}
	
	public function View($name) {
		$view = new Sippy_view($name);
		return $view;
	}
	
	public function Plugin($name) {
		require(APP_DIR .'plugins/'. strtolower($name) .'.php');
	}
	
	public function Helper($name) {
		require(APP_DIR .'helpers/'. strtolower($name) .'.php');
		$helper = new $name;
		return $helper;
	}

	public function redirect($loc) {
		global $config;

		if ( empty($loc) ) {
			$this->logger->log_message('error', 'A Redirect is empty:: class (system/controller.php)');
			exit;
		} else {
			header('Location: '. $config['base_url'] . $loc);
			exit;
		}
		
	}


    
}
