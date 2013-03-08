<?php

namespace wpmvc\Controllers;

class PageController extends Base
{
	protected $model;

	public function __construct($template, $options = array())
	{
		parent::__construct($template, $options);
		$this->model = new \wpmvc\Models\Page($options);
		$this->model->find();
		$this->render();
	}
}