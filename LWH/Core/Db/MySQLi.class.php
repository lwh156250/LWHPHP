<?php
namespace Core\Db;

class MySQLi{
	protected $conn;

	function connect($host, $user, $password, $dbname){
		$conn = mysqli_connect($host, $user, $password, $dbname);
		$this->conn = $conn;
		return $this;
	}

	function query($sql){
		return mysqli_query($this->conn, $sql);
	}

	function getAll($sql){
		$result = mysqli_query($this->conn, $sql);
		$array = null;
		while ($row = $result->fetch_assoc()) {
			$array[] = $row;
		}
		return $array;
	}

	function close(){
		mysqli_close($this->conn);
	}
}