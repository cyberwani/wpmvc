<?php

namespace wpmvc\Helpers\Query;

class Author extends Base
{
	protected $queryArgs = array(
		"fields" => "all_with_meta"
	);

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
	}

	public function run()
	{
		if (isset($this->options["id"])) {
			$users = array(get_userdata($this->options["id"]));

		} else if (isset($this->options["post_id"])) {
			// return wp_get_post_terms($this->options["post_id"], $this->taxonomy);
		
		} else {
			$users = get_users($this->queryArgs);
		}

		return array_map(function($v) {
			return $this->extract($v);
		}, $users);

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
		$total = count_users();
		$total = $total["total_users"];
		$per_page = $this->options["per_page"];
		
		return round($total / $per_page, 0, PHP_ROUND_HALF_UP);
	}

	/**
	 * Extract properties out of the WP_User object
	 * @param  WP_User $userObject
	 * @return object Object with extracted properties
	 *                from the WP_User object.
	 */
	public function extract($userObject)
	{
		$user = new \StdClass();
		$user->id = $userObject->ID;
		$user->display_name = $userObject->display_name;
		$user->first_name = $userObject->user_firstname;
		$user->last_name = $userObject->user_lastname;
		$user->email = $userObject->user_email;
		$user->url = $userObject->user_url;
		$user->description = $userObject->description;
		return $user;
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
		$this->queryArgs["offset"] = ($v - 1) * $this->options["per_page"];
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