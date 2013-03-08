<?php

namespace wpmvc\Controllers;

class Base
{
	public function __construct($options)
	{
		
	}

	abstract protected function render();
}