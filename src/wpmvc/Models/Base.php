<?php

namespace wpmvc\Models;

class Base
{
	protected $options;

	/**
	 * Arguments send to Query helper. Arguments
	 * are in wpmvc format; not wordpress.
	 * @var associative array
	 */
	protected $queryArgs;

	public $data;
	
	public function __construct($options)
	{
		$this->options = $options;

		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	public function findOne()
	{
		$resultset = $this->find();
		$this->data = array_shift($resultset);
	}

	public function findAll()
	{
		$resultset = $this->find();
		$this->data = $resultset;
	}

	protected function find()
	{
		$query = new \wpmvc\Helpers\WordPressQuery($this->queryArgs);
		$results = $query->run();
		return $this->prepareData($results);
	}

	protected function prepareData($results)
	{
		foreach ($results as $item) {
			$item->url = get_permalink($item->ID);
		}
		return $results;
	}
}