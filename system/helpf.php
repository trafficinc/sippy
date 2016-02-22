<?php
/**
 * Sippy functions
 */


	/**
	 * Is HTTPS?
	 *
	 * Determines if the application is accessed via an encrypted
	 * (HTTPS) connection.
	 *
	 * @return	bool
	 */
function is_https() {

		if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
			return TRUE;
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
			return TRUE;
		} elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
			return TRUE;
		}
		return FALSE;
}

function load_config() {
	$cfg = Config::getInstance();
	$config = $cfg->getconfig();
	return $config;
}

function convert($size) {
	//ex.::echo convert(memory_get_usage()) . "\n";
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

function log_message($type, $errmess) {
	$cfg = Config::getInstance();
	$config = $cfg->getconfig();
	if ($config['activate_logs']) {
		$log = new Sippy_log($config);
		$log->log_message($type, $errmess);
	}
}


function site_url($objmeth = NULL) {
	$cfg = Config::getInstance();
	$config = $cfg->getconfig();
	if ( empty($objmeth) ) {
		return $config['base_url'];
	} else {
		return $config['base_url'] . $objmeth;
	}
}