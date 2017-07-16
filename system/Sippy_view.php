<?php

class Sippy_view {

	private   $pageVars = array();
	private   $template;
	protected $security;

	public function __construct($template, $data = NULL) {
		$this->security = new Security;
		if (empty($data)) {
			$this->template = realpath(APP_DIR .'views/'. $template .'.php');
		} else {
			$this->template = realpath(APP_DIR .'views/'. $template .'.php');
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
	
    public function error_block($errors) {
        if (isset($errors) && count($errors) > 0) {
            $errorCollection = [];
            foreach ($errors as $error) {
                $errorCollection[] = sprintf("<li class='list-group-item list-group-item-danger'>%s</li>",$error);
            }
            $html = "<ul class='errors list-group'>";
            $html .= implode(" ", $errorCollection);
            $html .= "</ul>";
            echo $html;
        }
    }

    public function success_block($mess) {
	    if (isset($mess)) {
            echo $mess;
        }
    }
    
}
