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
	}

	protected function buildQueryArgs()
	{
		$this->queryArgs["post_type"] = "post";
		$this->queryArgs["year"] = $this->year;
		$this->queryArgs["monthnum"] = $this->month;
		$this->queryArgs["day"] = $this->day;
		$this->queryAtgs["name"] = $this->slug;
	}
}