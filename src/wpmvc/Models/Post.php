<?php

namespace wpmvc\Models;

class Post extends Base
{
	public function __construct($options)
	{
		parent::__construct($options);
		$this->options = $options;
	}
}