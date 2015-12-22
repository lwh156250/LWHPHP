<?php
namespace Core\Db;

class MySQL{
	protected $conn;

	function connect($host, $user, $password, $dbname){
		$conn = mysql_connect($host, $user, $password);
		mysql_select_db($dbname, $conn);
		$this->conn = $conn;
		return $this;
	}

	function query($sql){
		return mysql_query($sql, $this->conn);
	}

	function getAll($sql){
		$result = mysql_query($sql, $this->conn);
		while($row = mysql_fetch_assoc($result)){
			$array[] = $row;
		}
		return $array;
	}

	function close(){
		mysql_close($this->conn);
	}
}