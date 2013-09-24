<?php

namespace wpmvc\Helpers;

class Pager
{
	protected $id;

	protected $totalPages;

	protected $currentPage;

	/**
	 * [__construct description]
	 * @param array $args Keys of totalPages, currentPage, and id (if applicable)
	 */
	public function __construct($args)
	{
		foreach ($args as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	public function paginate()
	{
		if (!is_null($this->id)) {
			global $post;
			$post = get_post($this->id);
		}

		return array(
			"currentPage" => $this->currentPage,
			"total" => $this->getTotalPages(),
			"prev" => $this->prevPage(),
			"next" => $this->nextPage()
		);
	}

	protected function getPostNavArgs($post)
	{
		if (empty($post)) {
			return null;
		}
		
		$author = get_userdata($post->post_author);
		$author = $author->data->user_nicename;

		return array(
			"id" => $post->ID,
			"slug" => $post->post_name,
			"pubDate" => strtotime($post->post_date_gmt),
			"author" => $author
		);
	}

	protected function nextPage()
	{
		if (!is_null($this->id)) {
			$nextPage = get_adjacent_post(false, "", false);
			return $this->getPostNavArgs($nextPage);

		} else if (!is_null($this->currentPage) && !is_null($this->totalPages)) {
			return $this->currentPage < $this->totalPages ? $this->currentPage + 1 : null;
		}

		return null;
	}

	protected function prevPage()
	{
		if (!is_null($this->id)) {
			$prevPage = get_adjacent_post();
			return $this->getPostNavArgs($prevPage);

		} else if (!is_null($this->currentPage) && !is_null($this->totalPages)) {
			return $this->currentPage > 1 ? $this->currentPage - 1 : null;
		}
	}

	protected function getTotalPages()
	{
		return $this->totalPages;
	}
}