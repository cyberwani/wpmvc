<?php

namespace wpmvc\Models;

class Page extends Base
{
	protected $slug;
	
	public function __construct($options)
	{
		parent::__construct($options);
	}

	protected function buildQueryArgs()
	{
		$this->queryArgs["post_type"] = "page";
		$this->queryArgs["pagename"] = implode("/", $this->slug);
	}
}