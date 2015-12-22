<?php
namespace Core\Db;

class PDO{
	protected $conn;
	function connect($host, $user, $password, $dbname){
		$conn = new \PDO("mysql::host=$host;dbname=$dbname", $user, $password);
		$this->conn = $conn;
		return $this;
	}

	function query($sql){
		return $this->conn->query($sql);
	}

	function getAll($sql){
		// $Statement = $this->conn->prepare($sql);
		// $result = $Statement->execute();
		// $result = $Statement->fetchAll(\PDO::FETCH_ASSOC);
		$result = $this->conn->query($sql);
		if($result){
			$result = $result->fetchAll(\PDO::FETCH_ASSOC);
		}		
		return $result;
	}

	function close(){
		unset($this->conn);
	}
}