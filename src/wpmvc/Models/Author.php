<?php

namespace wpmvc\Models;

class Author extends Base
{
	protected $fieldMap = array();
	
	public $id;
	public $display_name;
	public $first_name;
	public $last_name;
	public $email;
	public $url;
	public $description;


	public function __construct($recordset)
	{
		parent::__construct($recordset);
	}
}