<?php
namespace Core;

class App{
	static	private function init(){
		// 加载应用公共文件和配置
		// C(include CONF_PATH . 'config' .CONF_EXT);
        
        // 定义当前请求的系统常量
        define('NOW_TIME',      $_SERVER['REQUEST_TIME']);
        define('REQUEST_METHOD',$_SERVER['REQUEST_METHOD']);
        define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
        define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
        define('IS_PUT',        REQUEST_METHOD =='PUT' ? true : false);
        define('IS_DELETE',     REQUEST_METHOD =='DELETE' ? true : false);
        define('IS_AJAX',       (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false);

        // URL调度
        \Core\Dispatcher::run();

        // URL调度结束标签
        Hook::listen('url_dispatch');//没有对应的行为函数，返回null notes by lwh 2015-11-19
        return ;
	}

	static public function run(){
		\Core\Hook::listen('app_begin');
		App::init();
		
		// Session初始化
		session(C('SESSION_OPTIONS'));

		App::exec();
		\Core\Hook::listen('app_end');
	}

	static private function exec(){
		try{
			$class = "\\Controller\\" . CONTROLLER_NAME;
			$class = new $class;
			$class->{ACTION_NAME}();
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}