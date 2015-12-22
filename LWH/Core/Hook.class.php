<?php
namespace Core;

/**
* 将行为类放入静态数组，然后进行调用
*/
class Hook{
	static private $tags = array(
		'test'				=> array(
			'\Behavior\TestBehavior',
            '\Behavior\Test2Behavior',
		),
		'app_begin' 		=> array(
		),
		'app_end' 			=> array(
            '\Behavior\DbCloseBehavior',
		),
		'controller_begin' 	=>array(
		),
		'controller_end'	=>array(
		),
		'model_begin'		=>array(
		),
		'model_end'			=>array(
		),
		'view_begin'		=>array(
		),
		'view_end'			=>array(
		),
	);
    //该数组可以选择存为配置文件

	static public function add($tag,$name){
		if(!isset(self::$tags[$tag])){
            self::$tags[$tag]   =   array();
        }
        if(is_array($name)){
            self::$tags[$tag]   =   array_merge(self::$tags[$tag],$name);
        }else{
            self::$tags[$tag][] =   $name;
        }
	}

	static public function listen($tag, &$params=NULL){
		 if(isset(self::$tags[$tag])) {
            if(APP_DEBUG) {
                // G($tag.'Start');
                // trace('[ '.$tag.' ] --START--','','INFO');
            }
            foreach (self::$tags[$tag] as $name) {
                // APP_DEBUG && G($name.'_start');
                $result =   self::exec($name, $tag,$params);
                if(APP_DEBUG){
                    // G($name.'_end');
                    // trace('Run '.$name.' [ RunTime:'.G($name.'_start',$name.'_end',6).'s ]','','INFO');
                }
                // if(false === $result) {
                //     // 如果返回false 则中断插件执行
                //     return ;
                // }
            }
            if(APP_DEBUG) { // 记录行为的执行日志
                // trace('[ '.$tag.' ] --END-- [ RunTime:'.G($tag.'Start',$tag.'End',6).'s ]','','INFO');
            }
            return true;
        }
        return false;
	}

	static public function exec($name, $tag,&$params=NULL){
		if('Behavior' == substr($name,-8) ){
            // 行为扩展必须用run入口方法
            $tag    =   'run';
        }
        $addon   = new $name();
        return $addon->$tag($params);
	}
}