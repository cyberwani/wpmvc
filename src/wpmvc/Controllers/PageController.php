<?php

namespace wpmvc\Controllers;

class PageController extends Base
{
	protected $model;

	public function __construct($options)
	{
		parent::__construct($options);
		$this->model = new \wpmvc\Models\Page($options);
		$this->model->find();
		$this->render();
	}

	protected function render()
	{
		print_r($this->model->data);
	}
}