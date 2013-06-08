<?php

namespace wpmvc\Adapters\Routers\Silex;

use \wpmvc\Adapters\Routers\Silex\Route;

class Router implements \wpmvc\Interfaces\Router
{
	/**
	 * Silex object
	 * @var object
	 */
	protected $router;

	/**
	 * Defined routes
	 * @var array
	 */
	protected $routes = array();

	public function __construct($silex)
	{
		$this->router = $silex;
	}

	public function setDebug($boolean)
	{
		$this->router["debug"] = (bool) $boolean;
		return $this;
	}

	public function get($pattern, $callable)
	{
		$route = new Route($this->router, "get", $pattern, $callable);
		$this->routes[] = $route;
		return $route;
	}

	public function post($pattern, $callable)
	{
		$route = new Route($this->router, "post", $pattern, $callable);
		$this->routes[] = $route;
		return $route;
	}

	public function put($pattern, $callable)
	{
		$route = new Route($this->router, "post", $pattern, $callable);
		$this->routes[] = $route;
		return $route;
	}
	
	public function delete($pattern, $callable)
	{
		$route = new Route($this->router, "delete", $pattern, $callable);
		$this->routes[] = $route;
		return $route;
	}
	
	public function options($pattern, $callable)
	{
		$route = new Route($this->router, "options", $pattern, $callable);
		$this->routes[] = $route;
		return $route;
	}

	public function redirect($url)
	{
		$this->router->redirect($url);
	}

	public function abort($code, $message)
	{
		$this->router->abort($code, $message);
	}

	public function error($callable)
	{
		$this->router->error($callable);
	}

	public function run()
	{
		$this->router->run();
	}
}