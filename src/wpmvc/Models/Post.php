<?php

namespace wpmvc\Models;

class Post extends Base
{
	protected $year;
	protected $month;
	protected $day;
	protected $slug;

	public function __construct($options)
	{
		parent::__construct($options);

		$this->queryArgs = $options;
		$this->queryArgs["name"] = $this->slug;
	}
}