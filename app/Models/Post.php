<?php

namespace app\Models;

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
}