<?php

namespace wpmvc\Models;

class Page extends Base
{
	protected $fieldMap = array(
		"ID" => "id",
		"post_date" => "publish_date",
		"post_date_gmt" => "publish_date_gmt",
		"post_modified" => "last_modified",
		"post_modified_gmt" => "last_modified_gmt",
		"post_name" => "slug"
	);
	
	public $id;
	public $type;
	public $url;
	public $author;
	public $publish_date;
	public $publish_date_gmt;
	public $last_modified;
	public $last_modified_gmt;
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