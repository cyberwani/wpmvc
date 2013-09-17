<?php

namespace wpmvc\Adapters\Routers;

class Silex extends Base
{
	protected $notFoundHandler;

	public function error($callable = null)
	{
		$this->router->error($callable);
		
	}

	public function notFound($callable = null)
	{
		$this->router->abort(404);
	}
}