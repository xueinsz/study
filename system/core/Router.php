<?php
class Router {
    public static function display($uri) {
	    
		$pattern = "/(\w+)=(\w+)\/?(\w*)/";

		preg_match($pattern, $uri, $matches);
	
		$file = APPLICATION_CONTROLLER . $matches[2] . '.php';
		require_once($file);
		$class = ucwords($matches[2]);
		$controller = new $class;
		$method = !empty($matches[3]) ? $matches[3] : 'index';
		
		call_user_func_array(array($controller,$method),array());
	}

}

?>