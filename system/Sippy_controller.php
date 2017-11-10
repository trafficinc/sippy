<?php
defined('ROOT_DIR') OR exit('No direct script access allowed');


class Sippy_controller {

    public $flash;
    protected $config;
    protected $security;
    protected $validation;
    protected $html;

    public function __construct()
    {

        $config = load_config();
        $this->config = $config;
        $this->security = new Security;
        $this->html = new Html($config);
        $this->flash = new FlashMessages;
        $this->validation = new Validation;
    }
	
	public function Model($name) {
		require(APP_DIR .'models/'. $name .'.php');
		$model = new $name;
		return $model;
	}

    public function View($name, $data = NULL)
    {

        if (empty($data)) {
            $view = new Sippy_view($name,"",$this->config);
        } else {
            $view = new Sippy_view($name, $data, $this->config);
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
