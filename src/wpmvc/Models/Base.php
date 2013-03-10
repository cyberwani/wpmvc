<?php

namespace wpmvc\Models;

class Base
{
	/**
	 * Modified version of options passed into
	 * the model. Ready to be used in database
	 * query adapter.
	 * @var Associative array
	 */
	protected $options;

	/**
	 * Data retrieved from the model.
	 * @var mixed Array or object
	 */
	public $data;
	
	public function __construct($options)
	{
		$this->options = $options;
	}

	protected function find()
	{
		$query = new \wpmvc\Helpers\WordPressQuery($this->options);
		$results = $query->run();
		return $this->prepareData($results);
	}

	public function findOne()
	{
		$resultset = $this->find();
		$this->data = array_shift($resultset);
	}

	public function findMany()
	{
		$resultset = $this->find();
		$this->data = $resultset;
	}

	protected function prepareData($results)
	{
		foreach ($results as $item) {
			$item->url = get_permalink($item->ID);
		}
		return $results;
	}
}