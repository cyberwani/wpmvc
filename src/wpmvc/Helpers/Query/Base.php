<?php

namespace wpmvc\Helpers\Query;

abstract class Base
{
	/**
	 * Options passed into the query object
	 * @var array
	 */
	protected $options;

	/**
	 * Resultset
	 * @var array
	 */
	protected $results = array();

	/**
	 * Query arguments
	 * @var array
	 */
	protected $queryArgs = array();

	/**
	 * Runs a query argument builder for each option passed. 
	 * @param array $options Key/value query options
	 */
	public function __construct($options = array())
	{
		$this->options = $options;
		foreach ($options as $k => $v) {
			$method = "build__{$k}";
			if (method_exists($this, $method)) {
				$this->$method($v);
			}
		}
	}

	/**
	 * Runs the query and returns the data to the model.
	 * @return array Resultset
	 */
	abstract public function run();

	/**
	 * Gets the current page of the current
	 * query results
	 * @return int
	 */
	abstract public function getCurrentPage();

	/**
	 * Gets the total number of pages available in
	 * the current query
	 * @return int
	 */
	abstract public function getTotalPages();

	/**
	 * Takes care of joining an array together into
	 * a comma-demilited string (if needed)
	 * @param  mixed $v String or array
	 * @return string
	 */
	protected function join($v, $char = ",")
	{
		if (is_array($v)) {
			$v = implode($char, $v);
		}
		return $v;
	}

	/**
	 * Converts the id option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__id($v)
	{
		$this->queryArgs["id"] = $v;
		return $this;
	}

	/**
	 * Converts the order option into WP_Query friendly arguments.
	 * @param  string $v
	 * @return $this
	 */
	protected function build__order($v)
	{
		$this->queryArgs["order"] = $v;
		return $this;
	}

	/**
	 * Converts the order_by option into WP_Query friendly arguments.
	 * @param  string $v
	 * @return $this
	 */
	protected function build__order_by($v)
	{
		$this->queryArgs["orderby"] = $v;
		return $this;
	}
}