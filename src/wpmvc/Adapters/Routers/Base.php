<?php

namespace wpmvc\Adapters\Routers;

abstract class Base implements \wpmvc\Interfaces\Router
{
	/**
	 * Router object
	 * @var object
	 */
	protected $router;

	public function __construct($router)
	{
		$this->router = $router;
	}

	public function __get($field)
	{
		if (property_exists($this->router, $field)) {
			return $this->router->field;
		}
	}

	public function __call($method, $args)
	{
		if (method_exists($this->router, $method)) {
			return call_user_func_array(array($this->router, $method), $args);
		}
	}
}