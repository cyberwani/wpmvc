<?php

namespace wpmvc\Mappers;

class PageMapper extends Base
{
	protected $object = "Page";
	protected $collection = "PageCollection";

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

	protected function addDataToResult($item)
	{
		$item = parent::addDataToResult($item);

		$item->url = get_permalink($item->ID);

		return $item;
	}
}