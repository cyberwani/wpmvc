<?php

namespace wpmvc\Adapters\Routers\Silex;

class Route implements \wpmvc\Interfaces\Route
{
	/**
	 * Route object created when a method (i.e. GET)
	 * method is called. This is the object all subesquent
	 * methods (like name()) must be called on.
	 * 
	 * @var object
	 */
	protected $route;

	public function __construct($router, $method, $pattern, $callable)
	{
		$this->route = $router->$method($pattern, $callable);
	}

	public function name($name)
	{
		$this->route->bind($name);
		return $this;
	}
	
	public function condition($param, $regex)
	{
		$this->route->assert($param, $regex);
		return $this;
	}

	public function before($callable)
	{
		$this->route->before($callable);
		return $this;
	}

	public function after($callable)
	{
		$this->route->after($callable);
		return $this;
	}
}