<?php

namespace wpmvc\Controllers;

class PostController extends Base
{
	protected $modelName = "Post";

	public function __construct($template, $options = array())
	{
		parent::__construct($template, $options);

		$this->model->findOne();
		$this->render();
	}
}