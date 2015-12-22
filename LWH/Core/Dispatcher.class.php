<?php
namespace Core;

class Dispatcher{

	static public function run(){
	// 判断URL里面是否有兼容模式参数

	// 开启子域名部署

	// 分析PATHINFO信息		
	if(!isset($_SERVER['PATH_INFO'])) {
		$controller   = C('DEFAULT_CONTROLLER');
		$action       = C('DEFAULT_ACTION');
        }else{
        	$paths         = trim($_SERVER['PATH_INFO'],'/');
                $paths         = str_replace(C('URI_ALLOW_SUFFIX'), '', $paths);
        	$depr 	       = C('DEFAULT_DEPR');
        	$paths         = explode($depr,$paths,2);
        	$controller    = array_shift($paths);
        	$controller    = empty($controller) ? C('DEFAULT_CONTROLLER') : $controller;
        	$action        = array_shift($paths);
        	$action        = empty($action) ? C('DEFAULT_ACTION') : $action;
        }
        //Controller、Action常量
        define('CONTROLLER_NAME', 	ucfirst(strtolower($controller)));
        define('ACTION_NAME', 		strtolower($action));

        // URL常量
        define('__SELF__',strip_tags($_SERVER['REQUEST_URI']));
        
	$_REQUEST = array_merge($_POST,$_GET);
	}
}