<?php

namespace Core;

class Router {

    /**
	 *
	 */
	private $routes = array();
	
	/**
	 *
	 */
	private $method = '';
	
	/**
	 *
	 */
	private $notFound = '';
	
	/**
	 * @var string Current baseroute, used for (sub)route mounting
	 */
	private $baseroute = '';
    
	
	
	public function getRequestMethods(){}
	
	/**
	 * 执行callback回调函数
	 */
	public function run($callback = null) {
    
    	// Handle all routes
		$numHandled = 0;
		
		$this->method = 'GET';
		//$this->routes['get'][] = array('pattern'=>'/(\w+)(\d+)');

		if (isset($this->routes[$this->method])) {
		    // handle返回是否有需要处理的请求
			$numHandled = $this->handle($this->routes[$this->method], true);
		}
		
		// 判断是否有请求要处理
		if ($numHandled == 0) {
			if ($this->notFound && is_callable($this->notFound)) {
				call_user_func($this->notFound);
			} else {
				header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
			}
		}
		// If a route was handled, perform the finish callback (if any)
		else {
			if ($callback) $callback();
		}
	}
	
	public function get($pattern, $fn) {
		$this->match('GET', $pattern, $fn);
	}
	
	public function match($methods, $pattern, $fn) {

		$pattern = $this->baseroute . '/' . trim($pattern, '/');
		$pattern = $this->baseroute ? rtrim($pattern, '/') : $pattern;

		foreach (explode('|', $methods) as $method) {
			$this->routes[$method][] = array(
				'pattern' => $pattern,
				'fn' => $fn
			);
		}

	}
	
	/**
	 * Get the request method used, taking overrides into account
	 * @return string The Request method to handle
	 */
	public function getRequestMethod() {

		// Take the method as found in $_SERVER
		$method = $_SERVER['REQUEST_METHOD'];

		// If it's a HEAD request override it to being GET and prevent any output, as per HTTP Specification
		// @url http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.4
		if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
			ob_start();
			$method = 'GET';
		}

		// If it's a POST request, check for a method override header
		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$headers = $this->getRequestHeaders();
			if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], array('PUT', 'DELETE', 'PATCH'))) {
				$method = $headers['X-HTTP-Method-Override'];
			}
		}

		return $method;

	}
	
	/**
	 * 根据当前uri从所有已经定义好的路由中匹配
	 × 匹配后执行相关动作
	 */
	public function handle($routes, $quitAfterRun = false) {
		// Counter to keep track of the number of routes we've handled
		$numHandled = 0;
	    
		// The current page URL
		$uri = $this->getCurrentUri();
//echo $uri;		
		// Loop all routes
		foreach ($routes as $route) {
		    // we have a match!
			if (preg_match_all("#^" . $route['pattern'] . "$#", $uri, $matches, PREG_OFFSET_CAPTURE/*PREG_SET_ORDER*/)) {

			    // Rework matches to only contain the matches, not the orig string
				$matches = array_slice($matches, 1);
                
				// Extract the matched URL parameters (and only the parameters)
				$params = array_map(function($match, $index) use ($matches) {

					// We have a following parameter: take the substring from the current param position until the next one's position (thank you PREG_OFFSET_CAPTURE)
					if (isset($matches[$index+1]) && isset($matches[$index+1][0]) && is_array($matches[$index+1][0])) {
						return trim(substr($match[0][0], 0, $matches[$index+1][0][1] - $match[0][1]), '/');
					}

					// We have no following paramete: return the whole lot
					else {
						return (isset($match[0][0]) ? trim($match[0][0], '/') : null);
					}

				}, $matches, array_keys($matches));		
				
			}
	
			call_user_func_array($route['fn'], $params);
			
			// yay!
			$numHandled++;

			if ($quitAfterRun) break;
		}
		
		return $numHandled;
		
	}
	
	/**
	 * Define the current relative URI
	 * @return string
	 */
	private function getCurrentUri() {

		// Get the current Request URI and remove rewrite basepath from it (= allows one to run the router in a subfolder)
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));

		// Don't take query params into account on the URL
		if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));

		// Remove trailing slash + enforce a slash at the start
		$uri = '/' . trim($uri, '/');

		return $uri;

	}

}

?>