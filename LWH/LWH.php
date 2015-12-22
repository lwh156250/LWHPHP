<?php
// +----------------------------------------------------------------------
// | LwhPHP [ My Personal Php Framework]
// +----------------------------------------------------------------------
// | Author: 刘伟煌<523888297@qq.com、kt5511581@163.com>
// +----------------------------------------------------------------------

//版本信息
const LWH_VERSION = '1.0.1';

//类文件后缀
const EXT = '.class.php';
const CONF_EXT = '.php';

//系统常量定义
defined('BASE_PATH') 	or define('BASE_PATH', 		dirname(__DIR__) . '/');
defined('LWH_PATH')		or define('LWH_PATH',		__DIR__.'/');
defined('APP_PATH')     or define('APP_PATH',       './Application/');
defined('APP_NAME')		or define('APP_NAME',		trim(APP_PATH, './'));
defined('APP_DEBUG')    or define('APP_DEBUG',      false); // 是否调试模式
defined('APP_MODE')    	or define('APP_MODE',      'common'); // 开发模式 common--普通网页开发

defined('ASSETS_PATH')  or define('ASSETS_PATH',	APP_NAME . '/Assets');
defined('VIEW_PATH')    or define('VIEW_PATH',		APP_NAME . '/View');
defined('MODEL_PATH')   or define('MODEL_PATH',		APP_NAME . '/Model');

// defined('CORE_PATH')    or define('CORE_PATH',      LWH_PATH . 'Core/'); // LWH类库目录
// defined('CONF_PATH')	or define('CONF_PATH', 		APP_PATH . 'Conf/');
// defined('APP_MODE')     or define('APP_MODE',       'common'); // 应用模式 默认为普通模式    
// defined('STORAGE_TYPE') or define('STORAGE_TYPE',   'File'); // 存储类型 默认为File    
// defined('LIB_PATH')     or define('LIB_PATH',       realpath(LWH_PATH.'Library').'/'); // 

// defined('BEHAVIOR_PATH')or define('BEHAVIOR_PATH',  LIB_PATH.'Behavior/'); // 行为类库目录
// defined('MODE_PATH')    or define('MODE_PATH',      THINK_PATH.'Mode/'); // 系统应用模式目录
// define('_PHP_FILE_',    rtrim($_SERVER['SCRIPT_NAME'],'/'));
// $_root  =   rtrim(dirname(_PHP_FILE_),'/');
// define('__ROOT__',  (($_root=='/' || $_root=='\\')?'':$_root));
if(!APP_DEBUG) error_reporting(0);
require LWH_PATH . '/Core/LWH' .EXT;
Core\LWH::start();