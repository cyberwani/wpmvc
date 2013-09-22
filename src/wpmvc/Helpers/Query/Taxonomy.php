<?php

namespace wpmvc\Helpers\Query;

class Taxnomy extends Base
{


	/**
	 * Converts the parent option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__parent($v)
	{
		$this->queryArgs["parent"] = $v;
		return $this;
	}

	/**
	 * Converts the page option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__page($v)
	{
		$this->queryArgs["offset"] = $v;
		return $this;
	}

	/**
	 * Converts the per_page option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__per_page($v)
	{
		$this->queryArgs["number"] = $v;
		return $this;
	}

	/**
	 * Converts the slug option into WP_Query friendly arguments.
	 * @param  string $v
	 * @return $this
	 */
	protected function build__slug($v)
	{
		$this->queryArgs["slug"] = $v;
		return $this;
	}
}