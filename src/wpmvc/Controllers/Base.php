<?php

namespace wpmvc\Controllers;

class Base
{
	protected $template;

	public function __construct($template, $options = array())
	{
		$this->template = $template;
	}

	protected function render()
	{
		$data = $this->model->data;
		include $this->template;
	}
}