<?php


class Sippy_controller {

	public 	  $flash;
	protected $config;
	protected $security;
    	protected $validation;

	public function __construct() {

		$config = load_config();
        	$this->config = $config;
		$this->security = new Security;
        	$this->flash = new FlashMessages;
        	$this->validation = new Validation;
	}
	
	public function Model($name) {
		require(APP_DIR .'models/'. $name .'.php');
		$model = new $name;
		return $model;
	}
	
	public function View($name, $data = NULL) {
		if (empty($data)) {
			$view = new Sippy_view($name);
		} else {
			$view = new Sippy_view($name,$data);
		}
		return $view;
	}
	
	public function Plugin($name) {
		require(APP_DIR .'plugins/'. $name .'.php');
	}
	
	public function Helper($name) {
		require(APP_DIR .'helpers/'. $name .'.php');
		$helper = new $name;
		return $helper;
	}

	public function redirect($loc) {
		if ( !empty($loc) ) {
			header('Location: '. $this->config["base_url"] . $loc);
			exit;
		}
	}

}
