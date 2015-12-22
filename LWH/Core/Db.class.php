<?php
namespace Core;

class Db{
	protected static $db = array();
	protected static $dbConnectType;

	//提示不可以去new一个对象
	private function __construct($host, $user, $password, $dbname, $type, $dbConnectType = 'pdo'){
		if(!extension_loaded($dbConnectType)) {
			header('Content-Type:text/html; charset=utf-8');
        	die('没有'.$dbConnectType.'数据库扩展！');
        }
        self::$dbConnectType = $dbConnectType;
		//不同数据库类型连接
		switch ($dbConnectType) {
			case 'mysql':
				$db = new Db\MySQL();
				break;
			
			case 'mysqli':
				$db = new Db\MySQLi();
				break;

			case 'pdo':
				$db = new Db\PDO();
				break;

			default :
				$db = new Db\MySQLi;
		}
		self::$db[$type] = $db->connect($host, $user, $password, $dbname);
	}

	//单例模式--获取数据库连接
	static function getInstance($type = 'master', $dbConnectType = 'pdo'){
		if(isset(self::$db[$type])){
			return self::$db[$type];
		}else{
			$config = include APP_PATH.'Conf/database'.CONF_EXT;			
			$config = $type=='master' ? $config['master'] : array_rand($config['slave']);
			new self($config['host'], $config['user'], $config['password'], $config['dbname'], $type, $dbConnectType);
			return self::$db[$type];
		}
	}

	//关闭数据库连接
	static function dbClose(){
		if(!empty($db)){
			foreach ($db as $value) {
				$value->close();
			}
		}
	}
}