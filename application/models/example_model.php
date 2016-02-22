<?php

class Example_model extends Sippy_model {
	
	public function getSomething() {
		$id = $this->escapeString($id);
		$result = $this->query('SELECT * FROM something WHERE id="'. $id .'"');
		return $result;
	}

}

