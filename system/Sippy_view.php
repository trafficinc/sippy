<?php

class Sippy_view {

	private $pageVars = array();
	private $template;

	public function __construct($template, $data = NULL) {
		if (empty($data)) {
			$this->template = APP_DIR .'views/'. $template .'.php';
		} else {
			$this->template = APP_DIR .'views/'. $template .'.php';
			$this->data_handler($data);
		}
 
	}

	public function set($var, $val) {
		$this->pageVars[$var] = $val;
	}

	public function render() {
		extract($this->pageVars);

		ob_start();
		require($this->template);
		echo ob_get_clean();
	}

	public function data_handler($data) {

	    if (is_array($data)) {
			foreach ($data as $dta => $val) {
				$this->set($dta, $val);
			}
		}

	}





    
}
