<?php

namespace wpmvc\Models;

class Page extends Base
{
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
	public $attachments = array();

	public function __construct($recordset)
	{
		parent::__construct($recordset);
	}
}