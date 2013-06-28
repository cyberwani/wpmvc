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
		$item->featured_image = $this->getFeaturedImage($item);

		return $item;
	}

	/**
	 * Get the featured image on the given item.
	 * @param  object $item Post object
	 * @return array
	 */
	protected function getFeaturedImage($item)
	{
		$args = array(
			"id" => get_post_thumbnail_id($item->ID),
			"status" => "any"
		);

		$mapper = new AttachmentMapper($args);
		$mapper->findOne();
		
		return $mapper->data["result"];
	}
}