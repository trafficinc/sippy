<?php


class Sippy_controller {

	protected $config;

	public function __construct() {

		$config = load_config();
        $this->config = $config;
       
	}
	
	public function Model($name) {
		require(APP_DIR .'models/'. ucfirst($name) .'.php');
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
		require(APP_DIR .'plugins/'. strtolower($name) .'.php');
	}
	
	public function Helper($name) {
		require(APP_DIR .'helpers/'. strtolower($name) .'.php');
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
