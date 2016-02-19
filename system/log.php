<?php

/**
 * Log Errors and Debugging info:
 * 	Allowed types of logs:
 * 		debug
 * 		error
 */

class Sippy_log {

	protected $_allowed_types = array('error','debug');
	protected $_log_path;
	protected $_canwrite = TRUE;
	protected $_date_fmt = 'Y-m-d H:i:s';
	protected $_file_permissions = 0644;


	public function __construct($active) {
		if (!$active) {
			return;
		}

		global $config;
		if ( empty($config['log_path']) ) {
			$this->_log_path = APP_DIR.'logs/';
		} else if ($config['log_path'] !== 'logs/' ) {
			$this->_log_path = APP_DIR.'logs/';
		} else {
			$this->_log_path = APP_DIR.$config['log_path'];
		}
		
		file_exists($this->_log_path) OR mkdir($this->_log_path, 0755, TRUE);

		if ( ! is_dir($this->_log_path) OR ! is_writable($this->_log_path)) {
			$this->_canwrite = FALSE;
		}

	}

	public function log_message($type, $errmess) {
		
		if ($this->_canwrite === FALSE) {
			return FALSE;
		}

		if (!in_array($type, $this->_allowed_types)) {
			$this->log_message('debug', "ERROR, type '{$type}' not allowed!");
		} else {

			$filepath = $this->_log_path.'log-'.date('Y-m-d').'.txt';
			$message = '';
			if ( ! file_exists($filepath)) {
				$newfile = TRUE;
			}
			if ( ! $fp = @fopen($filepath, 'ab')) {
				return FALSE;
			}
			$date = date($this->_date_fmt);
			$message = $this->_format_line($type, $date, $errmess);

			flock($fp, LOCK_EX);
			for ($written = 0, $length = strlen($message); $written < $length; $written += $result) {
				if (($result = fwrite($fp, substr($message, $written))) === FALSE) {
					break;
				}
			}
			flock($fp, LOCK_UN);
			fclose($fp);

			if (isset($newfile) && $newfile === TRUE) {
				chmod($filepath, $this->_file_permissions);
			}


			return is_int($result);


		}
	}


	protected function _format_line($type, $date, $errmess) {
		return $type.' - '.$date.' --> '.$errmess."\n";
	}


}