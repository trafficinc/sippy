<?php
defined('ROOT_DIR') OR exit('No direct script access allowed');

class Example_model extends Sippy_model {
	
	public function getUser($id) {
		$id = $this->escapeString($id);
		$result = $this->getrowobj('SELECT * FROM users WHERE id="'. $id .'"');
		return $result;
	}

}

