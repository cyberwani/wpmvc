<?php

namespace wpmvc\Mappers;

class AttachmentMapper extends Base
{
	protected $object = "Attachment";
	protected $collection = "AttachmentCollection";

	protected function prepareOptions($options)
	{
		$options["type"] = "attachment";
		if (isset($options["id"])) {
			$options["p"] = $options["id"];
			unset($options["id"]);
		}

		parent::prepareOptions($options);
	}

	protected function addDataToResult($item)
	{
		$item = parent::addDataToResult($item);

		$item->url = wp_get_attachment_url($item->ID);
		$item->alt_text = get_post_meta($item->ID, "_wp_attachment_image_alt", true);

		return $item;
	}
}