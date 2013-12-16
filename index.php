<?php

require('/config.php');


// 实现自动加载框架核心函数和库
/*function system_loader($class) {
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

$router = new Router();

$controller = Router::display($_SERVER['QUERY_STRING']);
*/

require_once(SYS_CORE . 'Router.php');
$router = new \Core\Router();

require_once(SYS_CORE . 'Action.php');
$action = new \Core\Action();

$router->get('/www',function(){
});

$router->run(function() use ($action){
    $action->display('www');
});