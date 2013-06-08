<?php

namespace wpmvc\Models;

class Attachment extends Base
{
	/**
	 * Run any necessary alterations/additions
	 * to the options and then set off to the model.
	 * @param  array $options Key/value query options
	 * @return null
	 */
	protected function prepareOptions($options)
	{
		$options["type"] = "attachment";
		if (isset($options["id"])) {
			$options["p"] = $options["id"];
			unset($options["id"]);
		}

		parent::prepareOptions($options);
	}
}