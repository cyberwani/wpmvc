<?php

namespace wpmvc\Models;

class Base
{
	protected $options;

	protected $filterWhere;

	protected $queryArgs = array(
		"fields" => "ids"
	);

	public $data;
	
	public function __construct($options)
	{
		$this->options = $options;

		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}

		$this->buildQueryArgs();
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
		if (is_callable($this->filterWhere)) {
			add_filter("posts_where", $this->filterWhere);
		}

		$query = new \WP_Query($this->queryArgs);

		if (is_callable($this->filterWhere)) {
			remove_filter("posts_where", $this->filterWhere);
		}
		
		$ids = $query->posts;
		foreach ($ids as $id) {
			$results[] = get_post($id);
		}

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