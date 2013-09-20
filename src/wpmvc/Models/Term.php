<?php

namespace wpmvc\Models;

class Term extends Base
{
	protected $fieldMap = array(
		"term_id" => "id",
		"term_group" => "group"
	);
	
	public $id;
	public $name;
	public $slug;
	public $url;
	public $group;
	public $description;
	public $parent;
	public $count;
	
	public function __construct($recordset)
	{
		parent::__construct($recordset);
	}
}