<?php

/**
 * Sippy::Config singleton
 */

class Config {
	
	private $_config_settings;
	private static $instance;

	protected function __construct() {
        $config = null;
		require(APP_DIR .'config/config.php');
		$this->_config_settings = $config;
	}

   public static function getInstance() {
     if(self::$instance == NULL) {
      self::$instance = new Config();
     }
     return self::$instance;
   }

   public function getconfig() {
   	 return $this->_config_settings;
   }

}