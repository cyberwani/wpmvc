<?php

namespace wpmvc\Controllers;

class CollectionController extends Base
{
	protected $model;

	public function __construct($template, $options = array())
	{
		parent::__construct($template, $options);
		$this->model = new \wpmvc\Models\Collection($options);
		$this->model->collect();
		$this->render();
	}
}