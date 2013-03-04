<?php

namespace app\Controllers;

class PostController extends Base
{
	public function __construct($options)
	{
		parent::__construct($options);
		$model = new \app\Models\Post($options);
	}
}