<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
//define('DB_PASSWORD', '#K0p1d03l03');
define('DB_DATABASE', 'estate');


class DB_con {
	public $connection;
	function __construct(){
		$this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);

		if ($this->connection->connect_error) die('Database error -> ' . $this->connection->connect_error);

	}

	function OpenCon(){
		return $this->connection;
	}

	function CloseCon(){
		return mysqli_close($this->connection);
	}
}

?>