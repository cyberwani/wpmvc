<?php

namespace wpmvc\Adapters\Routers\Slim;

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

	/**
	 * Stores route conditions for compiling at runtime
	 * @var array
	 */
	protected $conditions = array();

	/**
	 * Stores route middleware for compiling at runtime
	 * @var array
	 */
	protected $middleware = array();


	public function __construct($router, $method, $pattern, $callable)
	{
		$this->route = $router->$method($pattern, $callable);
	}

	public function condition($param, $regex)
	{
		$this->conditions[$param] = $regex;
		return $this;
	}

	public function before($callable)
	{
		$this->middleware[] = $callable;
		return $this;
	}

	/**
	 * No Slim support for after middleware
	 * @return self
	 */
	public function after($callable)
	{
		return $this;
	}

	public function name($name)
	{
		$this->route->name($name);
		return $this;
	}

	public function setConditions()
	{
		$this->route->setConditions($this->conditions);
	}

	public function setMiddleware()
	{
		$this->route->setMiddleware($this->middleware);
	}
}