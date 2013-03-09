<?php

namespace wpmvc\Controllers;

class CollectionController extends Base
{
	protected $modelName = "Collection";

	public function __construct($template, $options = array())
	{
		parent::__construct($template, $options);

		$this->model->findAll();
		$this->render();
	}
}