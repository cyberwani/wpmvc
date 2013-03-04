<?php

namespace app\Models;

class Page extends Base
{
	protected $slug;
	public $data;

	public function __construct($options)
	{
		parent::__construct($options);
	}
	
	public function find()
	{
		$slug = implode("/", $this->slug);
		$this->data = get_page_by_path($slug);
	}
}