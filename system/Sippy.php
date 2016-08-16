<?php

class Sippy {

	public $_config;
	public $_hook;

	public function __construct($config,$hook) {
		$this->_config = $config;
		$this->_hook = $hook;
		$this->router();
	}

	public function router() {
	
	    // Set our defaults
	    $controller = $this->_config['default_controller'];
	    $action = 'index';
	    $url = '';
		
		// Get request url and script url
		$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

		// Get our url path and trim the / of the left and the right
		if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
		// Split the url into segments
		$segments = explode('/', $url);

		// Do our default checks
		if(isset($segments[0]) && $segments[0] != '') $controller = ucfirst($segments[0]);
		if(isset($segments[1]) && $segments[1] != '') $action = $segments[1];

		// Get our controller file
	    $path = APP_DIR . 'controllers/' . $controller . '.php';
		if(file_exists($path)){
	        require_once($path);
		} else {
	        $controller = $this->_config['error_controller'];
	        require_once(APP_DIR . 'controllers/' . $controller . '.php');
		}
	    
	    // Check the action exists
	    if(!method_exists($controller, $action)){
	        $controller = $this->_config['error_controller'];
	        require_once(APP_DIR . 'controllers/' . $controller . '.php');
	        $action = 'index';
	    }

	    $this->_hook->call_hook('before_controller');
		// Create object and call method
		$obj = new $controller($this->_config);

		call_user_func_array(array($obj, $action), array_slice($segments, 2));
		$this->_hook->call_hook('after_controller');

	}




}