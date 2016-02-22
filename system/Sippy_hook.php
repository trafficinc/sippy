<?php

class Sippy_hook {

	public $_hook_activated = FALSE;
	public $_hooks =	array();

	public function __construct($active) {
		
		if (!$active) {
			return;
		}
		if (file_exists(APP_DIR.'config/hooks.php')) {

			include(APP_DIR.'config/hooks.php');
		}

		$this->_hooks =& $hook;
		$this->_hook_activated = TRUE;
	}

	public function call_hook($isname = '') {

		if ( !$this->_hook_activated || !isset($this->_hooks[$isname])) {
			return FALSE;
		}
		if (is_array($this->_hooks[$isname]) && ! isset($this->_hooks[$isname]['function'])) {

			foreach ($this->_hooks[$isname] as $val) {
				$this->_run_hook($val);
			}

		} else {
			$this->_run_hook($this->_hooks[$isname]);
		}

		return TRUE;
	}


	protected function _run_hook($data)
	{
		// Closures/lambda function
		if (is_callable($data))	{
			is_array($data) ? $data[0]->{$data[1]}() : $data();

			return TRUE;
		} elseif ( ! is_array($data)) {
			return FALSE;
		}
	}



}