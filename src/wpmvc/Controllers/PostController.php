<?php

namespace wpmvc\Controllers;

class PostController extends Base
{
	public function __construct($options)
	{
		parent::__construct($options);
		$model = new \wpmvc\Models\Post($options);
	}

	protected function render()
	{
		print_r($this->model->data);
	}
}