<?php
namespace Core;

class Model{
	private $conn;

	public function __construct(){
		$this->conn = \Core\Db::getInstance();
	}

	public function query($sql){
		return $this->conn->query($sql);
	}

	public function getAll($sql){
		return $this->conn->getAll($sql);
	}

}