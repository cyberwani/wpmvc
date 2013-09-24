<?php

namespace wpmvc\Mappers;

abstract class Base
{
	/**
	 * Modified version of options passed into
	 * the model. Ready to be used in database
	 * query adapter.
	 * @var Associative array
	 */
	protected $options;

	/**
	 * WP_Query object
	 * @var object
	 */
	protected $query;

	/**
	 * Data retrieved from the model.
	 * @var mixed Array or object
	 */
	public $data;
	
	/**
	 * Saves passed options to the model.
	 * @param array $options Key/value query options
	 */
	public function __construct($options)
	{
		$this->prepareOptions($options);		
	}

	/**
	 * Run any necessary alterations/additions
	 * to the options and then set off to the model.
	 * @param  array $options Key/value query options
	 * @return null
	 */
	protected function prepareOptions($options)
	{
		$this->options = $options;
	}

	/**
	 * Instantiates the Query helper, runs the query,
	 * and then prepares the result.
	 * @return array Resultset
	 */
	protected function find()
	{
		$this->query = new \wpmvc\Helpers\Query\Post($this->options);
		$results = $this->query->run();
		return $this->mapExtraDataToEachResult($results);
	}

	/**
	 * Used by models looking for one result.
	 * @return $data
	 */
	public function findOne()
	{
		$found = $this->find();
		$recordset = array_shift($found);
		$this->data = $this->hydrate($recordset);
		$this->wpmvcAddToPayload();
		$this->addPagination();
		$this->addToPayload();
		return $this->data;
	}

	/**
	 * Used by models looking for many results.
	 * @return $data
	 */
	public function findMany()
	{
		$recordset = $this->find();
		$this->data = $this->hydrate($recordset);
		$this->wpmvcAddToPayload();
		$this->addPagination();
		$this->addToPayload();
		return $this->data;
	}

	/**
	 * Adds various things to the entire payload.
	 * Used internally by WPMVC. The method addToPayload()
	 * is available to end users for this puspose.
	 * @return $this
	 */
	protected function wpmvcAddToPayload()
	{
		$this->data["site"] = $this->getSiteData();
	}

	protected function addPagination()
	{
		$args = array(
			"totalPages" => $this->query->getTotalPages(),
			"currentPage" => $this->query->getCurrentPage()
		);

		if (isset($this->data["results"]->id)) {
			$args["id"] = $this->data["results"]->id;
		}
		$pager = new \wpmvc\Helpers\Pager($args);

		$this->data["pagination"] = $pager->paginate();
	}

	/**
	 * Used by user-end mappers to add data to the entire
	 * payload. Child mappers in WPMVC use wpmvcAddToPayload()
	 * @return $this
	 */
	protected function addToPayload()
	{
		
	}

	protected function getSiteData()
	{
		return array(
			"name" =>  get_bloginfo("name"),
			"description" => get_bloginfo("description"),
			"wpurl" => get_bloginfo("wpurl"),
			"url" => get_bloginfo("url"),
			"admin_email" => get_bloginfo("admin_email"),
			"charset" => get_bloginfo("charset"),
			"version" => get_bloginfo("version"),
			"html_type" => get_bloginfo("html_type"),
			"text_direction" => get_bloginfo("text_direction"),
			"language" => get_bloginfo("language"),
			"header" => $this->captureEcho("wp_head"),
			"footer" => $this->captureEcho("wp_footer")
		);
	}

	protected function captureEcho($method)
	{
		ob_start();
		$method();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	/**
	 * Add additional data to each result in addition
	 * to what WP_Query provided.
	 * @param  array $results Resultset
	 * @return array Resultset
	 */
	protected function mapExtraDataToEachResult($results)
	{
		return array_map(function($item) {
			$item = $this->wpmvcAddData($item);
			return $this->addData($item);
		}, $results);
	}

	/**
	 * Add (or alter) data on an individual item. This method
	 * is used internally by WPMVC. The method addData() is
	 * available to end users for this purpose as.
	 * @param object $item WP object
	 */
	protected function wpmvcAddData($item)
	{
		$item->post_date = strtotime($item->post_date);
		$item->post_date_gmt = strtotime($item->post_date_gmt);
		$item->post_modified = strtotime($item->post_modified);
		$item->post_modified_gmt = strtotime($item->post_modified_gmt);
		$item->post_content = apply_filters("the_content", $item->post_content);
		$item->post_excerpt = $this->createExcerpt($item);
		$item->taxonomy = $this->getTerms($item);

		return $item;
	}

	/**
	 * Used bye user-end mappers to add data to each item in the result
	 * set. Child mappers in WPMVC piggyback off wpmvcAddData().
	 * @param object $item WP object
	 */
	protected function addData($item)
	{
		return $item;
	}

	/**
	 * Fill a model's properties with the values
	 * from the given recordset
	 * @param $recordset Object of array of obejcts
	 * @return array
	 */
	abstract protected function hydrate($recordset);

	
	

	/**
	 * If an except doesn't exist already, create one. 
	 * @param  object $item Post object
	 * @return string The excerpt
	 */
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

	protected function getMeta($id)
	{
		$meta = get_post_meta($id);
		$pretty = array();
		foreach ($meta as $k => $v) {
			$first = substr($k, 0, 1);
			if ($first == "_") {
				$k = substr($k, 1);
			}
			if (count($v) == 1) {
				$v = array_pop($v);
			}
			$pretty[$k] = $v;
		}

		return $pretty;
	}

	/**
	 * Gets terms on the given item for all
	 * taxonomies attached to the item's post type.
	 * @param  object $item Post object
	 * @return array
	 */
	protected function getTerms($item)
	{
		$taxonomies = get_object_taxonomies($item);
		$terms = array();

		foreach ($taxonomies as $taxonomy) {
			$args = array(
				"post_id" => $item->ID,
				"taxonomy" => $taxonomy
			);
			$mapper = new TermMapper($args);
			$mapper->findMany();

			$nickname = str_replace("post_", "", $taxonomy);
			$terms[$nickname] = $mapper->data["results"];

			$terms[$nickname] = array_map(function($term) use ($taxonomy) {
				return new \wpmvc\Models\Term($term);
			}, $terms[$nickname]);
		}

		return $terms;
	}

	/**
	 * Get attachments that are related to
	 * the given item.
	 * @param  object $item Post object
	 * @return array
	 */
	protected function getAttachments($item)
	{
		$args = array(
			"parent" => $item->ID,
			"per_page" => -1,
			"status" => "any"
		);

		$mapper = new AttachmentMapper($args);
		$mapper->findMany();
		
		return $mapper->data["results"];
	}

	/**
	 * Get the author of the given item.
	 * @param  object $item Post object
	 * @return array
	 */
	protected function getAuthor($item)
	{
		$args = array(
			"id" => $item->post_author
		);
		$mapper = new AuthorMapper($args);
		$mapper->findOne();
		return $mapper->data["results"];
	}
}