<?php

namespace wpmvc\Helpers;

class Query
{
	/**
	 * WP_Query object-ready arguments
	 * @var array
	 */
	public $queryArgs = array(
		"fields" => "ids",
		"posts_per_page" => 10
	);

	/**
	 * Filter function used to alter the
	 * WHERE statement of a query if
	 * necessary.
	 * @var callale
	 */
	protected $filterWhere;

	/**
	 * WP_Query object
	 * @var object
	 */
	protected $wpquery;

	/**
	 * Resultset
	 * @var array
	 */
	protected $results = array();

	/**
	 * Runs a query argument builder for each
	 * option passed. 
	 * @param array $options Key/value query options
	 */
	public function __construct($options = array())
	{
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
	public function run()
	{
		if (is_callable($this->filterWhere)) {
			add_filter("posts_where", $this->filterWhere);
		}

		$this->wpquery = new \WP_Query($this->queryArgs);

		if (is_callable($this->filterWhere)) {
			remove_filter("posts_where", $this->filterWhere);
		}

		$ids = $this->wpquery->posts;

		foreach ($ids as $id) {
			$this->results[] = get_post($id);
		}

		return $this->prepareData($this->results);
	}

	/**
	 * Runs any necessary modifications on the resultset.
	 * @param  array $results Resultset
	 * @return array Modified resultset
	 */
	protected function prepareData($results)
	{
		foreach ($results as $item) {
			$item->post_date = strtotime($item->post_date);
			$item->post_excerpt = $this->createExcerpt($item);

			$item->url = get_permalink($item->ID);
		}
		return $results;
	}

	protected function createExcerpt($item)
	{
		if (!empty($item->post_excerpt)) {
			return $item->post_excerpt;
		}

		$words = explode(" ", strip_tags($item->post_content), 75);
		array_pop($words);
		$excerpt = implode(" ", $words);

		return rtrim($excerpt, ".");
	}

	/**
	 * Takes care of joining an array together into
	 * a string (if needed)
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
	 * Converts the author option into WP_Query friendly arguments.
	 * @param  mixed $v String, integer or array of sting and integers.
	 * @return $this
	 */
	protected function build__author($v)
	{
		$v = $this->join($v);
		$this->queryArgs["author"] = $v;
		return $this;
	}

	/**
	 * Converts the category option into WP_Query friendly arguments.
	 * @param  mixed $v String, integer or array of sting and integers.
	 * @return $this
	 */
	protected function build__category($v)
	{
		if (!is_array($v)) {
			$v = array($v);
		}
		$v = array_map(function($value) {
			if (!is_numeric($value)) {
				$category = get_category_by_slug($value);
				$value = $category->term_id;
			}
			return $value;
		}, $v);

		$v = $this->join($v);
		$this->queryArgs["category__in"] = $v;
		return $this;
	}

	/**
	 * Converts the day option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__day($v)
	{
		$this->queryArgs["day"] = $v;
		return $this;
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
	 * Converts the month option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__month($v)
	{
		$this->queryArgs["monthnum"] = $v;
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

	/**
	 * Converts the page option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__page($v)
	{
		$this->queryArgs["paged"] = $v;
		return $this;
	}

	/**
	 * Converts the pagination option into WP_Query friendly arguments.
	 * @param  boolean $v
	 * @return $this
	 */
	protected function build__pagination($v)
	{
		$this->queryArgs["nopaging"] = $v;
		return $this;
	}

	/**
	 * Converts the path option into WP_Query friendly arguments.
	 * @param  array $v
	 * @return $this
	 */
	protected function build__path($v)
	{
		$this->queryArgs["pagename"] = implode("/", $v);
		return $this;
	}

	/**
	 * Converts the permission option into WP_Query friendly arguments.
	 * @param  string $v
	 * @return $this
	 */
	protected function build__permission($v)
	{
		$this->queryArgs["perm"] = $v;
		return $this;
	}

	/**
	 * Converts the per_page option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__per_page($v)
	{
		$this->queryArgs["posts_per_page"] = $v;
		return $this;
	}

	/**
	 * Converts the tag option into WP_Query friendly arguments.
	 * @param  mixed $v String, integer or array of sting and integers.
	 * @return $this
	 */
	protected function build__tag($v)
	{
		if (!is_array($v)) {
			$v = array($v);
		}
		$v = array_map(function($value) {
			if (!is_numeric($value)) {
				$tag = get_tags(array("slug" => $value));
				$tag = array_shift($tag);
				$value = $tag->term_id;
			}
			return $value;
		}, $v);

		$v = $this->join($v);
		$this->queryArgs["tag__in"] = $v;
		return $this;
	}

	/**
	 * Converts the slug option into WP_Query friendly arguments.
	 * @param  string $v
	 * @return $this
	 */
	protected function build__slug($v)
	{
		$this->queryArgs["name"] = $v;
		return $this;
	}

	/**
	 * Converts the time option into WP_Query friendly arguments.
	 * @param  mixed $v String or array
	 * @return $this
	 */
	protected function build__time($v)
	{
		if (is_array($v)) {
			$this->filterWhere = function($where = "") use ($v) {
				$where .= " AND post_date >= '{$v[0]}' AND post_date < '{$v[1]}'";
				return $where;
			};

		} else {
			$timePeriods = array("year", "monthnum", "day");
			$v = explode("-", $v);
			for ($i = 0; $i < count($v); $i++) {
				$this->queryArgs[$timePeriods[$i]] = $v[$i];
			}
		}
		return $this;
	}

	/**
	 * Converts the type option into WP_Query friendly arguments.
	 * @param  string $v
	 * @return $this
	 */
	protected function build__type($v)
	{
		$this->queryArgs["post_type"] = $v;
		return $this;
	}

	/**
	 * Converts the sticky option into WP_Query friendly arguments.
	 * @param  boolean $v
	 * @return $this
	 */
	protected function build__sticky($v)
	{
		$this->queryArgs["ignore_sticky_posts"] = !$v;
		return $this;
	}

	/**
	 * Converts the year option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__year($v)
	{
		$this->queryArgs["year"] = $v;
		return $this;
	}
}