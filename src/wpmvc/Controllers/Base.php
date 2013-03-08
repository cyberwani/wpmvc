<?php

namespace wpmvc\Controllers;

class Base
{
	protected $template;

	public function __construct($options)
	{
		
	}

	public function setTemplate($file)
	{
		$this->template($file);
	}

	protected function render()
	{
		$data = $this->model->data;
		include $template;
	}
}