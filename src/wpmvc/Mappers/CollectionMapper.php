<?php

namespace wpmvc\Mappers;

use \wpmvc\Helpers\ClassFinder;

class CollectionMapper extends Base
{
	protected function addDataToResult($item)
	{
		$mapper = ClassFinder::find("Mappers", ucfirst($item->post_type) . "Mapper");
		$mapper = new $mapper(array());

		$item = $mapper->addDataToResult($item);

		return $item;
	}
}