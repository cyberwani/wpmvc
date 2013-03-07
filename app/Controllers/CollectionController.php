<?php

namespace app\Controllers;

class CollectionController extends Base
{
	protected $model;

	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->model = new \app\Models\Collection($options);
		$this->model->collect();
		$this->render();
	}

	protected function render()
	{
		$data = $this->model->data;
		require dirname(__DIR__) . "/views/collection.php";
	}
}