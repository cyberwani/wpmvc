<?php

namespace wpmvc\Controllers;

class PostController extends Base
{
	public function __construct($template, $options = array())
	{
		parent::__construct($template, $options);
		$model = new \wpmvc\Models\Post($options);
	}
}