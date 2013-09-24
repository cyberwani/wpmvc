<?php

namespace wpmvc\Mappers;

use \wpmvc\Helpers\ClassFinder;

class TermMapper extends Base
{
	protected $object = "Term";

	public function __construct($options)
	{
		if (!isset($options["taxonomy"])) {
			throw new \InvalidArgumentException("`taxonomy` options required.");
		}
		parent::__construct($options);
	}

	public function find()
	{
		$this->query = new \wpmvc\Helpers\Query\Taxonomy($this->options);
		$results = $this->query->run();
		return $this->mapExtraDataToEachResult($results);
	}

	public function findOne()
	{
		$found = $this->find();
		$recordset = array_shift($found);
		$this->data = $this->hydrate($recordset);
		$this->wpmvcAddToPayload();
		$this->addPagination();
		$this->addToPayload();
		return $this->data;
	}

	public function findMany()
	{
		$recordset = $this->find();
		$this->data = $this->hydrate($recordset);
		$this->wpmvcAddToPayload();
		$this->addPagination();
		$this->addToPayload();
		return $this->data;
	}

	protected function hydrate($recordset)
	{
		if (empty($recordset)) {
			$data = $recordset;
		}

		else if (is_array($recordset)) {

			$data = array_map(function($item) {
				$model = ClassFinder::find("Models", ucfirst($this->object));
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
		$item->url = get_term_link((int) $item->term_id, $this->options["taxonomy"]);
		return $item;
	}
}