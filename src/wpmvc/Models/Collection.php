<?php

namespace wpmvc\Models;

class Collection extends Base
{
	protected $queryArgs = array(
		"post_type" => "post",
		"posts_per_page" => 10
	);

	public function __construct($options)
	{
		parent::__construct($options);
	}

	protected function buildQueryArgs()
	{
		foreach ($this->options as $k => $v) {

			$method = "build__{$k}";
			if (method_exists($this, $method)) {
				$this->$method($v);
			}
		}
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

	protected function build__tag($v)
	{
		$v = $this->join($v);
		$this->queryArgs["tag__in"] = $v;
	}

	protected function build__category($v)
	{
		$v = $this->join($v);
		$this->queryArgs["category__in"] = $v;
	}

	protected function build__type($v)
	{
		$this->queryArgs["post_type"] = $v;
	}

	protected function build__per_page($v)
	{
		$this->queryArgs["posts_per_page"] = $v;
	}

	protected function build__page($v)
	{
		$this->queryArgs["paged"] = $v;
	}

	protected function build__pagination($v)
	{
		$this->queryArgs["nopaging"] = $v;
	}

	protected function build__order($v)
	{
		$this->queryArgs["order"] = $v;
	}

	protected function build__order_by($v)
	{
		$this->queryArgs["orderby"] = $v;
	}

	protected function build__sticky($v)
	{
		$this->queryArgs["ignore_sticky_posts"] = $v;
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

	protected function build__permission($v)
	{
		$this->queryArgs["perm"] = $v;
	}
}