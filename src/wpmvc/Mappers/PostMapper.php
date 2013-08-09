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

	protected function wpmvcAddData($item)
	{
		$item = parent::wpmvcAddData($item);

		$item->url = get_permalink($item->ID);
		$item->attachments = $this->getAttachments($item);
		// $item->featured_image = $this->getFeaturedImage($item);
		$item->meta = get_post_meta($item->ID);

		return $item;
	}

	/**
	 * Get the featured image on the given item.
	 * @param  object $item Post object
	 * @return array
	 */
	protected function getFeaturedImage($item)
	{
		$featureId = get_post_thumbnail_id($item->ID);

		if (empty($featureId)) {
			return null;
		}

		$args = array(
			"id" => $featureId,
			"status" => "any"
		);

		$mapper = new AttachmentMapper($args);
		$mapper->findOne();
		
		return $mapper->data["result"];
	}
}