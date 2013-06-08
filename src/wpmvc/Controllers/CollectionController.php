<?php

namespace wpmvc\Controllers;

class CollectionController extends Base
{
	protected $modelName = "Collection";

	/**
	 * Default template name
	 * @var string
	 */
	protected $template = "collection";

	/**
	 * Runs the parent constructor, gets the data
	 * from the model and renders the view.
	 * @param array  $options  Key/value query options
	 * @param string $template Absolute location of template.
	 * @return null
	 */
	public function __construct($options = array(), $template = null)
	{
		parent::__construct($options, $template);

		$this->model->findMany();
		$this->render();
	}
}