<?php

namespace wpmvc\Models;

class Page extends Base
{
	protected $slug;
	
	public function __construct($options)
	{
		parent::__construct($options);

		$this->queryArgs = array(
			"type" => "page",
			"pagename" => implode("/", $this->slug)
		);
	}
}