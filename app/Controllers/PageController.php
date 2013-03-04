<?php

namespace app\Controllers;

class PageController extends Base
{
	protected $model;

	public function __construct($options)
	{
		parent::__construct($options);
		$this->model = new \app\Models\Page($options);
		$this->model->find();
		$this->render();
	}

	protected function render()
	{
		$data = $this->model->data;
		require dirname(__DIR__) . "/views/page.php";
	}
}