<?php

namespace wpmvc\Models;

class Page extends Base
{
	/**
	 * Run any necessary alterations/additions
	 * to the options and then set off to the model.
	 * @param  array $options Key/value query options
	 * @return null
	 */
	protected function prepareOptions($options)
	{
		$options["type"] = "page";
		if (isset($options["id"])) {
			$options["page_id"] = $options["id"];
			unset($options["id"]);
		}

		parent::prepareOptions($options);
	}
}