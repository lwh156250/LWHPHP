<?php
return array(
	// 配置文件
	'config' =>	array(
		LWH_PATH . 'Conf/config.php',
		APP_PATH . 'Conf/config.php',        
	),
	// 函数和类文件
	'core' => array(		
		LWH_PATH . 'Common/functions.php',
		APP_PATH . 'Common/functions.php',
	),
	// 行为扩展定义  ----见LWH/Core/Hook.class.php----
	'tags' => array(
	),
);