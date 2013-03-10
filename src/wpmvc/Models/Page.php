<?php

namespace wpmvc\Models;

class Page extends Base
{
	public function __construct($options)
	{
		parent::__construct($options);
		$this->options = array(
			"type" => "page"
		);
	}
}