<?php

namespace wpmvc\Mappers;

class PostMapper extends Base
{
	protected $object = "Post";
	protected $collection = "PostCollection";

	/**
	 * Run any necessary alterations/additions
	 * to the options and then set off to the model.
	 * @param  array $options Key/value query options
	 * @return null
	 */
	protected function prepareOptions($options)
	{
		if (isset($options["id"])) {
			$options["p"] = $options["id"];
			unset($options["id"]);
		}
	
		parent::prepareOptions($options);
	}

	protected function addDataToResult($item)
	{
		$item = parent::addDataToResult($item);

		$item->url = get_permalink($item->ID);

		return $item;
	}
}