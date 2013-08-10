<?php

namespace wpmvc\Models;

class Page extends Base
{
	protected $fieldMap = array(
		"ID" => "id",
		"post_name" => "slug"
	);
	
	public $id;
	public $type;
	public $url;
	public $author;
	public $date;
	public $date_gmt;
	public $modified;
	public $modified_gmt;
	public $content;
	public $title;
	public $excerpt;
	public $status;
	public $slug;
	public $parent;
	public $comment_status;
	public $comment_count;
	public $attachments = array();
	public $meta = array();

	public function __construct($recordset)
	{
		parent::__construct($recordset);
	}
}