<?php

namespace wpmvc\Controllers;

class PageController extends Base
{
	protected $mapperName = "Page";

	/**
	 * Default template name
	 * @var string
	 */
	protected $template = "page";

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

		$this->mapper->findOne();
		$this->render();
	}
}