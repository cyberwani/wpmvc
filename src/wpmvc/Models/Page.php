<?php

namespace wpmvc\Models;

class Page extends Base
{
	public function __construct($options)
	{
		parent::__construct($options);
		$this->options["type"] = "page";

		if (isset($this->options["id"])) {
			$this->options["page_id"] = $this->options["id"];
			unset($this->options["id"]);
		}
	}
}