<?php

namespace wpmvc\Helpers\Query;

class Taxonomy extends Base
{
	/**
	 * Mapping a nice taxonomy name
	 * to a WordPress taxonomy name
	 * @var array
	 */
	protected $taxMappery = array(
		"tag" => "post_tag"
	);

	/**
	 * Taxonomy to query.
	 * @var string
	 */
	protected $taxonomy;

	public function __construct($options = array())
	{
		// if not set in options, get posts per page from WP admin
		if (!isset($options["per_page"])) {
			$options["per_page"] = get_option("posts_per_page");
		}

		if (!isset($options["page"])) {
			$options["page"] = 1;
		}

		parent::__construct($options);

		if (in_array($options["taxonomy"], $this->taxMappery)) {
			$this->taxonomy = $this->taxMappery[$options["taxonomy"]];
		} else {
			$this->taxonomy = $options["taxonomy"];
		}
	}

	public function run()
	{
		if (isset($this->options["id"])) {
			return array(get_term($this->options["id"], $this->taxonomy));
		} else {
			return get_terms($this->taxonomy, $this->queryArgs);
		}
	}

	public function getCurrentPage()
	{
		return $this->options["page"];
	}

	public function getTotalPages()
	{
		if (isset($this->options["id"])) {
			return 1;
		}
		$total = wp_count_terms($this->taxonomy);
		$per_page = $this->options["per_page"];
		
		return round($total / $per_page, 0, PHP_ROUND_HALF_UP);
	}

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