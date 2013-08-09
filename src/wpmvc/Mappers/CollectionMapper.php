<?php

namespace wpmvc\Mappers;

use \wpmvc\Helpers\ClassFinder;

class CollectionMapper extends Base
{
	protected function wpmvcAddData($item)
	{
		$mapper = ClassFinder::find("Mappers", ucfirst($item->post_type));
		$mapper = new $mapper(array());

		$item = $mapper->wpmvcAddData($item);

		return $item;
	}
}