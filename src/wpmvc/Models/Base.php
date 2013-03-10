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
		$query = new \wpmvc\Helpers\Query($this->options);
		return $query->run();
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
}