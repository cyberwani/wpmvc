<?php

namespace wpmvc\Controllers;

class PostController extends Base
{
	protected $mapperName = "PostMapper";

	/**
	 * Default template name
	 * @var string
	 */
	protected $template = "post";

	/**
	 * Runs the parent constructor, gets the data
	 * from the mapper and renders the view.
	 * @param array  $options  Key/value query options
	 * @param string $template Absolute location of template.
	 * @return null
	 */
	public function __construct($options = array(), $template = null)
	{
		parent::__construct($options, $template);
		$data = $this->mapper->findOne();
		$data = $this->mapper->addDataToPayload($data);
		$this->render($data);
	}
}