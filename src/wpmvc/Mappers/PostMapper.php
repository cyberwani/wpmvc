<?php

namespace wpmvc\Mappers;

class PostMapper extends Base
{
	protected $object = "Post";
	protected $collection = "PostCollection";

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
		$item->attachments = $this->getAttachments($item);
		$item->featuredImage = $this->getFeaturedImage($item);

		return $item;
	}
}