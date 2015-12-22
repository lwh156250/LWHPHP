<?php
namespace Core;

class LWH {
	// 实例化对象
	private static $_instance = array();

	static public function start(){
		//注册AUTOLOAD方法
		spl_autoload_register('Core\LWH::autoload');

		//注册错误处理函数
		register_shutdown_function('Core\LWH::fatalError');//致命错误处理
		set_error_handler('Core\LWH::appError');		//普通错误处理
		// set_exception_handler('Core\LWH::appException');//异常处理自定义throw new \Exception($e);

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

		\Core\App::run();
	}

	static public function autoload($className){
		$file = null;
		if(is_file(APP_PATH.str_replace('\\', '/', $className).EXT)){
			$file = APP_PATH.str_replace('\\', '/', $className).EXT;
		}elseif (is_file(LWH_PATH.str_replace('\\', '/', $className).EXT)){
			$file = LWH_PATH.str_replace('\\', '/', $className).EXT;
		}else{
        	die($className.EXT . ' is not existent');
		}
		// is_file($file) && require_once $file;
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
                self::halt($e);
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
      self::halt($e);
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

    /**
     * 错误输出
     * @param mixed $error 错误
     * @return void
     */
    static public function halt($error) {
        $e = array();
        if (APP_DEBUG) {//APP_DEBUG || IS_CLI
            //调试模式下输出错误信息
            if (!is_array($error)) {
                $trace          = debug_backtrace();
                $e['message']   = $error;
                $e['file']      = $trace[0]['file'];
                $e['line']      = $trace[0]['line'];
                ob_start();
                debug_print_backtrace();
                $e['trace']     = ob_get_clean();
            } else {
                $e              = $error;
            }
            //兼容php其他运行模式
            // if(IS_CLI){
            //     exit(iconv('UTF-8','gbk',$e['message']).PHP_EOL.'FILE: '.$e['file'].'('.$e['line'].')'.PHP_EOL.$e['trace']);
            // }
        } else {
            //否则定向到错误页面
            $error_page         = C('ERROR_PAGE');
            if (!empty($error_page)) {
            	include($error_page);
              exit;
            } else {
                $message        = is_array($error) ? $error['message'] : $error;
                $e['message']   = C('SHOW_ERROR_MSG')? $message : C('ERROR_MESSAGE');
            }
        }
        // 包含异常页面模板
        $exceptionFile =  LWH_PATH.'View/lwh_exception.html';
        include $exceptionFile;
        exit;
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