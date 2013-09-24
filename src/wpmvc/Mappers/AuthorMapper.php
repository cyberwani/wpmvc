<?php

namespace wpmvc\Mappers;

use \wpmvc\Helpers\ClassFinder;

class AuthorMapper extends Base
{
	protected $object = "Author";

	public function __construct($options)
	{
		parent::__construct($options);
	}

	public function find()
	{
		$this->query = new \wpmvc\Helpers\Query\Author($this->options);
		$results = $this->query->run();
		return $this->mapExtraDataToEachResult($results);
	}

	public function findOne()
	{
		$found = $this->find();
		$recordset = array_shift($found);
		$this->data = $this->hydrate($recordset);
		$this->wpmvcAddToPayload();
		$this->addToPayload();
		return $this->data;
	}

	// admin isn't returned -- why?
	public function findMany()
	{
		$recordset = $this->find();
		$this->data = $this->hydrate($recordset);
		$this->wpmvcAddToPayload();
		$this->addPagination();
		$this->addToPayload();
		return $this->data;
	}

	protected function wpmvcAddData($item)
	{
		return $item;
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
}