<?php
return array(
	'DEFAULT_CONTROLLER' 		=> 'Home',		//默认访问Controller
	'DEFAULT_ACTION' 			=> 'Index',		//默认访问Action

	'DEFAULT_DEPR'			 	=> '/',			//分割符
	'TMPL_TEMPLATE_SUFFIX' 		=> '.html',		//模板文件后缀名
	'DEFAULT_CHARSET' 			=> 'utf-8',		//默认编码
	'TMPL_CONTENT_TYPE' 		=> 'text/html',	//默认类型
	'RUNTIME_SUFFIX' 			=> '.cache',	//缓存后缀
	'LAYOUT_ON' 				=> false,		//默认layout开启
	'DEFAULT_LAYOUT' 			=> null,		//默认layout文件位置
	'DEFAULT_TIMEZONE' 			=> 'Asia/Shanghai',			//默认时区
	'URI_ALLOW_SUFFIX' 			=> array('.html','.php'),	//访问后缀
	'DEFAULT_FILTER'        	=> 'htmlspecialchars', 		// 默认参数过滤方法 用于I函数...
	'ERROR_PAGE'				=> LWH_PATH.'View/error.html',//错误文件定位

	/* SESSION设置 */
    'SESSION_AUTO_START'    =>  true,    		// 是否自动开启Session
    'SESSION_OPTIONS'       =>  array(), 		// session 配置数组 支持type name id path expire domain 等参数
    'SESSION_TYPE'          =>  '', 			// session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX'        =>  '', 			// session 前缀
    // 'VAR_SESSION_ID'      =>  'session_id',     //sessionID的提交变量
);