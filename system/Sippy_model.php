<?php

class Sippy_model {

	private $connection;

	public function __construct() {
	    $config = load_config();
		
		$this->connection = mysqli_connect($config['db_host'].':'.$config['mysql_port'], $config['db_username'], $config['db_password'], $config['db_name']) or die('MySQL Error: '. $this->connection->error());

	}

	public function escapeString($string) {
		return $this->connection->real_escape_string($string);
	}

	public function escapeArray($array) {
	    array_walk_recursive($array, create_function('&$v', '$v = $this->connection->escape_string($v);'));
 		return $array;
	}
	
	public function to_bool($val) {
	    return !!$val;
	}
	
	public function to_date($val) {
	    return date('Y-m-d', $val);
	}
	
	public function to_time($val) {
	    return date('H:i:s', $val);
	}
	
	public function to_datetime($val) {
	    return date('Y-m-d H:i:s', $val);
	}
	
	public function query($qry) {
		$result = $this->connection->query($qry) or die('MySQL Error: '. $this->connection->error);
		$resultObjects = array();

		while($row = $result->fetch_object()) {
			$resultObjects[] = $row;
		}
		return $resultObjects;
	}
	
	//get one row and return an object
	public function getrowobj($qry) {
		$result = $this->connection->query($qry) or die('MySQL Error: '. $this->connection->error);
		$row = $result->fetch_object();
		return $row;
	}

	public function getrow($qry) {
		$result = $this->connection->query($qry) or die('MySQL Error: '. $this->connection->error);
		$row = $result->fetch_row();
		return $row;
	}

	public function execute($qry) {
		$exec = $this->connection->query($qry) or die('MySQL Error: '. $this->connection->error);
		return $exec;
	}
	
	public function insert($table, $data)
	{
		$columns = [];
		$values = [];
		foreach ($data as $k => $v) {
		    $columns[] = $k;
		    $values[] = "'{$v}'";
		}

		$sql = "INSERT INTO $table ";
		$sql .= "( ".implode(",",$columns)." )";
		$sql .= " VALUES ";
		$sql .= "( ".implode(",",$values)." )";
		$res = $this->execute($sql);
		if ($res) {
		    return $this->connection->insert_id;
		}
	    }
    
}

