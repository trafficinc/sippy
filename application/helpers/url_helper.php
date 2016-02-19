<?php

class Url_helper {

	public function site_url($objmeth = NULL) {
		global $config;

		if ( empty($objmeth) ) {
			return $config['base_url'];
		} else {
			return $config['base_url'] . $objmeth;
		}

	}
	
	public function segment($seg) {
		if(!is_int($seg)) {
			return false;
		}

		$parts = explode('/', $_SERVER['REQUEST_URI']);
	    return isset($parts[$seg]) ? $parts[$seg] : false;
	}
	
}
