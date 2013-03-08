<?php

namespace wpmvc\Controllers;

class CollectionController extends Base
{
	protected $model;

	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->model = new \wpmvc\Models\Collection($options);
		$this->model->collect();
		$this->render();
	}

	protected function render()
	{
		print_r($this->model->data);
	}
}