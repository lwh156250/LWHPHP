<?php
return array(
	'DEFAULT_CONTROLLER' 		=> 'Home',
	'DEFAULT_ACTION' 			=> 'Index',
	'DEFAULT_DEPR'			 	=> '/',
	'TMPL_TEMPLATE_SUFFIX' 		=> '.html',
	'DEFAULT_CHARSET' 			=> 'utf-8',
	'TMPL_CONTENT_TYPE' 		=> 'text/html',
	'RUNTIME_SUFFIX' 			=> '.cache',
	'LAYOUT_ON' 				=> false,
	'DEFAULT_LAYOUT' 			=> null,
	'DEFAULT_TIMEZONE' 			=> 'Asia/Shanghai',
	'URI_ALLOW_SUFFIX' 			=> array('.html','.php'),
	'DEFAULT_FILTER'        	=> 'htmlspecialchars', // 默认参数过滤方法 用于I函数...
	'ERROR_PAGE'				=> LWH_PATH.'View/error.html',

	/* SESSION设置 */
    'SESSION_AUTO_START'    =>  true,    // 是否自动开启Session
    'SESSION_OPTIONS'       =>  array(), // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_TYPE'          =>  '', // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX'        =>  '', // session 前缀
    //'VAR_SESSION_ID'      =>  'session_id',     //sessionID的提交变量
);