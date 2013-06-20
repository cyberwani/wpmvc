<?php

namespace wpmvc\Models;

class Attachment extends Base
{
	protected $fieldMap = array(
		"ID" => "id",
		"post_mime_type" => "type",
		"post_date" => "publish_date",
		"post_modified" => "last_modified",
		"post_name" => "slug",
		"post_excerpt" => "caption",
		"post_content" => "description"
	);

	public $id;
	public $type;
	public $url;
	public $author;
	public $publish_date;
	public $last_modified;
	public $description;
	public $title;
	public $caption;
	public $alt_text;
	public $status;
	public $slug;
	public $comment_status;
	public $comment_count;

	public function __construct($recordset)
	{
		parent::__construct($recordset);
	}
}