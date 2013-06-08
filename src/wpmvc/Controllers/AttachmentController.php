<?php

namespace wpmvc\Controllers;

class AttachmentController extends Base
{
	protected $modelName = "Attachment";

	/**
	 * Default template name
	 * @var string
	 */
	protected $template = "attachment";

	/**
	 * Runs the parent constructor, gets the data
	 * from the model and renders the view.
	 * @param string $template Absolute location of template.
	 * @param array  $options  Key/value query options
	 * @return null
	 */
	public function __construct($template, $options = array())
	{
		parent::__construct($template, $options);

		$this->model->findOne();
		$this->render();
	}
}