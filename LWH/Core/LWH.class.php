<?php
namespace Core;

class LWH {
	// 实例化对象
	private static $_instance = array();

	static public function start(){
		//注册AUTOLOAD方法
		spl_autoload_register('Core\LWH::autoload');

		\Core\Storage::connect('File');//选择文件存储引擎

		$mode = include LWH_PATH . 'Mode/' . APP_MODE . CONF_EXT;//模式配置文件

		//加载核心类与函数
		foreach ($mode['core'] as $file){
			is_file($file) && include $file;
		}

		//加载配置文件
		foreach ($mode['config'] as $file) {
			is_file($file) && C(include $file);
		}

		date_default_timezone_set(C('DEFAULT_TIMEZONE'));//设置时区
		
		//加载tags行为类
    
    //注册错误处理函数
    register_shutdown_function('Core\LWH::fatalError');//致命错误处理
    set_error_handler('Core\LWH::appError');    //普通错误处理
    // set_exception_handler('Core\LWH::appException');//异常处理自定义throw new \Exception($e);
    
		\Core\App::run();
	}

	static public function autoload($className){
		$file = null;
		if(is_file(APP_PATH.str_replace('\\', '/', $className).EXT)){
			$file = APP_PATH.str_replace('\\', '/', $className).EXT;
		}elseif (is_file(LWH_PATH.str_replace('\\', '/', $className).EXT)){
			$file = LWH_PATH.str_replace('\\', '/', $className).EXT;
		}else{
      return;
		}
		require_once $file;
	}

	//致命错误捕获
	static public function fatalError(){
		// Log::save();//错误日志记录
        if ($e = error_get_last()) {
            switch($e['type']){
              case E_ERROR:
              case E_PARSE:
              case E_CORE_ERROR:
              case E_COMPILE_ERROR:
              case E_USER_ERROR:  
                ob_end_clean();
                halt($e);
                break;
            }
        }       
	}

	/**
   * 自定义错误处理
   * @access public
   * @param int $errno 错误类型
   * @param string $errstr 错误信息
   * @param string $errfile 错误文件
   * @param int $errline 错误行数
   * @return void
   */
  static public function appError($errno, $errstr, $errfile, $errline) {
    if(error_reporting()==0){
      return;
    }
    $e['type'] = $errno;
    $e['message'] = $errstr;
    $e['file'] = $errfile;
    $e['line'] = $errline;
    halt($e);
  }

  /**
   * 自定义异常处理
   * @access public
   * @param mixed $e 异常对象
   */
  static public function appException($e) {
  	var_dump($e);
      // $error = array();
      // $error['message']   =   $e->getMessage();
      // $trace              =   $e->getTrace();
      // if('E'==$trace[0]['function']) {
      //     $error['file']  =   $trace[0]['file'];
      //     $error['line']  =   $trace[0]['line'];
      // }else{
      //     $error['file']  =   $e->getFile();
      //     $error['line']  =   $e->getLine();
      // }
      // $error['trace']     =   $e->getTraceAsString();
      // Log::record($error['message'],Log::ERR);
      // // 发送404信息
      // header('HTTP/1.1 404 Not Found');
      // header('Status:404 Not Found');
      // self::halt($error);
  }
    
	static public function instance($class,$method=''){
		$identify   =   $class.$method;
        if(!isset(self::$_instance[$identify])) {
            $o = new $class();
            if(!empty($method) && method_exists($o,$method))
                self::$_instance[$identify] = call_user_func(array(&$o, $method));
            else
                self::$_instance[$identify] = $o;
        }
        return self::$_instance[$identify];
	}
}