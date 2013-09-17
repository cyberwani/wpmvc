<?php

namespace wpmvc\Adapters\Routers;

class Slim extends Base
{
	public function error($callable = null)
	{
		$this->router->error($callable);
		
	}

	public function notFound($callable = null)
	{
		$this->router->notFound($callable);
	}
}