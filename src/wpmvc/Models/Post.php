<?php

namespace wpmvc\Models;

class Post extends Base
{
	public function __construct($options)
	{
		parent::__construct($options);

		if (isset($this->options["id"])) {
			$this->options["p"] = $this->options["id"];
			unset($this->options["id"]);
		}
	}
}