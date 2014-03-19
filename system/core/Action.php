<?php
namespace Core;
class Action {

    private $controller = '';
	private $method = '';
	private $params = array();
	
    public function display($controller,$method = '') {
	
		$file = APPLICATION_CONTROLLER . $controller . '.php';
		require_once($file);
		$class = ucwords($controller);
		
		$controller = new $class;
		
		$method = $method ? $method : 'index';
		
		
		
		call_user_func_array(array($controller,$method),array());
	}
}	
