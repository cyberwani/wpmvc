<?php

namespace wpmvc\Controllers;

class Base
{
	protected $template;
	protected $model;
	protected $modelName;

	public function __construct($template, $options = array())
	{
		$this->template = $template;
		$modelName = "\\wpmvc\\Models\\{$this->modelName}";
		$this->model = new $modelName($options);
	}

	protected function render()
	{
		$data = $this->model->data;
		include $this->template;
	}
}