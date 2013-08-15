<?php

namespace wpmvc\Models;

class Attachment extends Base
{
	protected $fieldMap = array(
		"ID" => "id",
		"post_excerpt" => "caption",
		"post_content" => "description"
	);

	public $id;
	public $type;
	public $url;
	public $description;
	public $caption;

	public function __construct($recordset)
	{
		parent::__construct($recordset);
	}
}