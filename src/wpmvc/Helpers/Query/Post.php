<?php

namespace wpmvc\Helpers\Query;

/**
 * Includes all kinds of posts -- post, page,
 * custom post types, attachments
 */
class Post extends Base
{
	protected $queryArgs = array(
		"fields" => "ids",
		"page" => 1,
		"post_type" => "post"
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

	public function __construct($options = array())
	{
		// if not set in options, get posts per page from WP admin
		if (!isset($options["per_page"])) {
			$options["per_page"] = get_option("posts_per_page");
		}

		parent::__construct($options);

		// custom taxonomies
		foreach ($options as $k => $v) {
			$method = "build__{$k}";
			if (in_array($k, $this->getCustomTaxonomies())) {
				$this->build__taxonomy($k, $v);
			}
		}
	}

	/**
	 * Retrive custom taxonomies.
	 * @return array Custom taxonomy names
	 */
	protected function getCustomTaxonomies()
	{
		$all = get_taxonomies();
		$default = array("category", "post_tag", "nav_menu", "link_category", "post_format");
		return array_diff($all, $default);
	}

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

		return $this->results;
	}

	public function getCurrentPage()
	{
		return $this->wpquery->query_vars["paged"];
	}

	public function getTotalPages()
	{
		return $this->wpquery->max_num_pages;
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
	 * Converts the p option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__p($v)
	{
		$this->queryArgs["p"] = $v;
		return $this;
	}

	/**
	 * Converts the parent option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__parent($v)
	{
		$this->queryArgs["post_parent"] = $v;
		return $this;
	}

	/**
	 * Converts the page_id option into WP_Query friendly arguments.
	 * @param  int $v
	 * @return $this
	 */
	protected function build__page_id($v)
	{
		$this->queryArgs["page_id"] = $v;
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
	 * Converts the status option into WP_Query friendly arguments.
	 * @param  string $v
	 * @return $this
	 */
	protected function build__status($v)
	{
		$this->queryArgs["post_status"] = $v;
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
	 * Converts the custom taxonomy option into WP_Query
	 * friendly arguments
	 * @param  string $tax Custom taxonomy name
	 * @param  mixed $v    String, integer or array of sting and integers.
	 * @return $this
	 */
	protected function build__taxonomy($tax, $v)
	{
		if (!is_array($v)) {
			$v = array($v);
		}
		$v = array_map(function($value) use ($tax) {
			if (!is_numeric($value)) {
				$term = get_term_by("slug", $value, $tax);
				$value = $term->term_id;
			}
			return $value;
		}, $v);

		$v = $this->join($v);

		$this->queryArgs["tax_query"] = array(
			array(
				"taxonomy" => $tax,
				"field" => "id",
				"terms" => $v
			)
		);
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