<?php
namespace Core;
class Action {
    public function display($uri) {
	
		$file = APPLICATION_CONTROLLER . $uri . '.php';
		require_once($file);
		$class = ucwords($uri);
		$controller = new $class;
		$method = !empty($matches[3]) ? $matches[3] : 'index';
		
		call_user_func_array(array($controller,$method),array());
	}
}	
