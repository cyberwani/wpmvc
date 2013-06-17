<?php

namespace wpmvc\Models;

class Post extends Base
{
	protected $fieldMap = array(
		"ID" => "id",
		"post_date" => "publish_date",
		"post_modified" => "last_modified",
		"post_name" => "slug"
	);
	
	public $id;
	public $type;
	public $url;
	public $author;
	public $publish_date;
	public $last_modified;
	public $content;
	public $title;
	public $excerpt;
	public $status;
	public $slug;
	public $parent;
	public $comment_status;
	public $comment_count;
	public $taxonomy = array();
	public $attachments = array();
	public $featured_image = array();
	public $pagination = array();

	public function __construct($recordset)
	{
		parent::__construct($recordset);
	}
}