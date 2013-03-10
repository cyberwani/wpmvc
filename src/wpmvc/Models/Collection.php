<?php

namespace wpmvc\Models;

class Collection extends Base
{
	public function __construct($options)
	{
		parent::__construct($options);
		$this->queryArgs = $options;
	}
}