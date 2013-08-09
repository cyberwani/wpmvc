<?php

namespace wpmvc\Mappers;

class PageMapper extends Base
{
	protected $object = "Page";

	protected function prepareOptions($options)
	{
		$options["type"] = "page";
		if (isset($options["id"])) {
			$options["page_id"] = $options["id"];
			unset($options["id"]);
		}

		parent::prepareOptions($options);
	}

	protected function wpmvcAddData($item)
	{
		$item = parent::wpmvcAddData($item);

		$item->url = get_permalink($item->ID);
		$item->attachments = $this->getAttachments($item);
		$item->meta = get_post_meta($item->ID);

		return $item;
	}
}