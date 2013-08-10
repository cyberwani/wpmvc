<?php

namespace wpmvc\Mappers;

use \wpmvc\Helpers\ClassFinder;

class AttachmentMapper extends Base
{
	protected $object = "Attachment";

	/**
	 * Fill a model's properties with the values
	 * from the given recordset
	 * @param $recordset Object of array of obejcts
	 * @return array
	 */
	protected function hydrate($recordset)
	{
		if (empty($recordset)) {
			$data = $recordset;
		}

		else if (is_array($recordset)) {

			$data = array_map(function($item) {
				$type = $this->getType($item);
				$model = ClassFinder::find("Models\\Attachments", ucfirst($type));
				return new $model($item);
			}, $recordset);

		} else {
			$type = $this->getType($recordset);
			$model = ClassFinder::find("Models\\Attachments", ucfirst($type));
			$data = new $model($recordset);
		}

		return array(
			"result" => $data
		);
	}

	/**
	 * Get the type of attachment model to
	 * instantiate based on the mime type.
	 * @param  object $item Attachment object
	 * @return string
	 */
	protected function getType($item)
	{
		switch ($item->post_mime_type) {
			case "image/jpeg":
			case "image/png":
			case "image/gif":
				return "Image";
				break;
			case "video/mpeg":
			case "video/mp4": 
			case "video/quicktime":
				return "Video";
				break;
			default:
				return "File";
		}
	}

	protected function prepareOptions($options)
	{
		$options["type"] = "attachment";
		if (isset($options["id"])) {
			$options["p"] = $options["id"];
			unset($options["id"]);
		}

		parent::prepareOptions($options);
	}

	protected function wpmvcAddData($item)
	{
		$item = parent::wpmvcAddData($item);

		$item->url = wp_get_attachment_url($item->ID);
		$item->alt_text = get_post_meta($item->ID, "_wp_attachment_image_alt", true);

		return $item;
	}
}