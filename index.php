<?php

// 全局变量
define('ROOT', 'd:/wamp/www/test/');
define('SYS_CORE', ROOT.'system/core/');
define('SYS_LIBS', ROOT.'system/libs/');
define('APPLICATION', ROOT.'application/');
define('APPLICATION_CONTROLLER', APPLICATION.'controller/');

// 实现自动加载框架核心函数和库
function system_loader($class) {
    if(is_file(SYS_CORE . $class . '.php')) {
	    require(SYS_CORE . $class . '.php');
	} else if(is_file(SYS_LIBS . $class . '.php')) {
	   require(SYS_LIBS . $class . '.php');
	}
}

// 注册函数到自动加载
spl_autoload_register('system_loader');

// 实例化xcache对象
$xcache = XCache::getInstance();

$controller = Router::display($_SERVER['QUERY_STRING']);
