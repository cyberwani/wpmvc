<?php

namespace wpmvc\Mappers;

use \wpmvc\Helpers\ClassFinder;

class PostMapper extends Base
{
	protected $object = "Post";

	protected function prepareOptions($options)
	{
		if (isset($options["id"])) {
			$options["p"] = $options["id"];
			unset($options["id"]);
		}
	
		parent::prepareOptions($options);
	}

	protected function hydrate($recordset)
	{
		if (empty($recordset)) {
			$data = $recordset;
		}

		else if (is_array($recordset)) {

			$data = array_map(function($item) {
				$model = ClassFinder::find("Models", ucfirst($item->post_type));
				return new $model($item);
			}, $recordset);

		} else {
			$model = ClassFinder::find("Models", ucfirst($this->object));
			$data = new $model($recordset);
		}

		return array(
			"results" => $data
		);
	}

	protected function wpmvcAddData($item)
	{
		$item = parent::wpmvcAddData($item);

		$item->url = get_permalink($item->ID);
		$item->attachments = $this->getAttachments($item);
		if ($this->hasFeatured()) {
			$item->featured_image = $this->getFeaturedImage($item);
		}
		$item->meta = $this->getMeta($item->ID);
		$item->author = $this->getAuthor($item);

		return $item;
	}

	/**
	 * Checks to see if the theme supports featured images.
	 * @return boolean TRUE if theme supports featured images;
	 *                 FALSE if theme does not support featured images.
	 */
	protected function hasFeatured()
	{
		return get_theme_support("post-thumbnails");
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
		
		return $mapper->data["results"];
	}
}