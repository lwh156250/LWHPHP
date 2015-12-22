<?php
namespace Behavior;

class DbcloseBehavior{
	public function run(){
		\Core\Db::dbClose();	
	}
}