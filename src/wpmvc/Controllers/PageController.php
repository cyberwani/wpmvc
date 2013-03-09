<?php

namespace wpmvc\Controllers;

class PageController extends Base
{
	protected $modelName = "Page";

	public function __construct($template, $options = array())
	{
		parent::__construct($template, $options);

		$this->model->findOne();
		$this->render();
	}
}