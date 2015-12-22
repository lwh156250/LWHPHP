<?php
// +----------------------------------------------------------------------
// | LwhPHP [ My Personal Php Framework][Refer To ThinkPHP]
// +----------------------------------------------------------------------
// | Author: 刘伟煌<523888297@qq.com、kt5511581@163.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);

// 定义应用目录
define('APP_PATH','./Application/');

// 引入入口文件
require './LWH/LWH.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单