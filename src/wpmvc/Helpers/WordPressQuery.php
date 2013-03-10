<?php

namespace wpmvc\Helpers;

/**
 * Takes (mostly) WordPress agnostic terms and
 * maps them to the WordPress WP_Query object.
 */
class WordPressQuery
{
	public $queryArgs = array(
		"fields" => "ids",
		"posts_per_page" => 10
	);

	protected $filterWhere;

	protected $results = array();

	public function __construct($options = array())
	{
		foreach ($options as $k => $v) {
			$method = "build__{$k}";
			if (method_exists($this, $method)) {
				$this->$method($v);
			}
		}
	}

	public function run()
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
			$this->results[] = get_post($id);
		}

		return $this->results;
	}

	protected function join($v, $char = ",")
	{
		if (is_array($v)) {
			$v = implode($char, $v);
		}
		return $v;
	}

	protected function build__author($v)
	{
		$v = $this->join($v);
		$this->queryArgs["author"] = $v;
	}

	protected function build__category($v)
	{
		$v = $this->join($v);
		$this->queryArgs["category__in"] = $v;
	}

	protected function build__day($v)
	{
		$this->queryArgs["day"] = $v;
	}

	protected function build__month($v)
	{
		$this->queryArgs["monthnum"] = $v;
	}

	protected function build__order($v)
	{
		$this->queryArgs["order"] = $v;
	}

	protected function build__order_by($v)
	{
		$this->queryArgs["orderby"] = $v;
	}

	protected function build__page($v)
	{
		$this->queryArgs["paged"] = $v;
	}

	protected function build__pagination($v)
	{
		$this->queryArgs["nopaging"] = $v;
	}

	protected function build__path($v)
	{
		$this->queryArgs["pagename"] = implode("/", $v);
	}

	protected function build__permission($v)
	{
		$this->queryArgs["perm"] = $v;
	}

	protected function build__per_page($v)
	{
		$this->queryArgs["posts_per_page"] = $v;
	}

	protected function build__tag($v)
	{
		$v = $this->join($v);
		$this->queryArgs["tag__in"] = $v;
	}

	protected function build__type($v)
	{
		$this->queryArgs["post_type"] = $v;
	}

	protected function build__slug($v)
	{
		$this->queryArgs["page"] = $v;
	}

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
	}

	protected function build__slug($v)
	{
		$this->queryArgs["name"] = $v;
	}

	protected function build__type($v)
	{
		$this->queryArgs["type"] = $v;
	}

	protected function build__sticky($v)
	{
		$this->queryArgs["ignore_sticky_posts"] = !$v;
	}

	protected function build__year($v)
	{
		$this->queryArgs["year"] = $v;
	}
}