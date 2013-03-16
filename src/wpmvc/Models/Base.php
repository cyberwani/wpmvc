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
	 * WP_Query object
	 * @var object
	 */
	protected $query;

	/**
	 * Data retrieved from the model.
	 * @var mixed Array or object
	 */
	public $data;
	
	/**
	 * Saves passed options to the model.
	 * @param array $options Key/value query options
	 */
	public function __construct($options)
	{
		$this->prepareOptions($options);		
	}

	/**
	 * Run any necessary alterations/additions
	 * to the options and then set off to the model.
	 * @param  array $options Key/value query options
	 * @return null
	 */
	protected function prepareOptions($options)
	{
		$this->options = $options;
	}

	/**
	 * Instantiates the Query helper, runs the query,
	 * and then prepares the result.
	 * @return array Resultset
	 */
	protected function find()
	{
		$this->query = new \wpmvc\Helpers\Query($this->options);
		return $this->query->run();
	}

	/**
	 * Used by models looking for one result.
	 * @return $this
	 */
	public function findOne()
	{
		$resultset = $this->find();
		$this->data = array_shift($resultset);
		return $this;
	}

	/**
	 * Used by models looking for many results.
	 * @return $this
	 */
	public function findMany()
	{
		$resultset = $this->find();
		$this->data = $resultset;
		return $this;
	}
}