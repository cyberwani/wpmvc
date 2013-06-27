<?php

namespace wpmvc\Mappers;

use \wpmvc\Helpers\ClassFinder;

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
		$this->query = new \wpmvc\Helpers\Query($this->options);
		$results = $this->query->run();
		return $this->mapExtraDataToEachResult($results);
	}

	/**
	 * Used by models looking for one result.
	 * @return $data
	 */
	public function findOne()
	{
		$recordset = array_shift($this->find());
		$this->data = $this->hydrate($recordset);
		$this->addDataToPayload();
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
		$this->addDataToPayload();
		return $this->data;
	}

	/**
	 * Adds the ability to add payload-wide data.
	 * @return $this
	 */
	public function addDataToPayload()
	{
		$args = array(
			"totalPages" => $this->query->getTotalPages(),
			"currentPage" => $this->query->getCurrentPage()
		);

		if (isset($this->data["result"]->id)) {
			$args["id"] = $this->data["result"]->id;
		}
		$pager = new \wpmvc\Helpers\Pager($args);

		$this->data["pagination"] = $pager->paginate();
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
			return $this->addDataToResult($item);
		}, $results);
	}

	/**
	 * Add (or alter) data on an individual item
	 * @param object $item WP object
	 */
	protected function addDataToResult($item)
	{
		$item->post_date = strtotime($item->post_date);
		$item->post_date_gmt = strtotime($item->post_date_gmt);
		$item->post_modified = strtotime($item->post_modified);
		$item->post_modified_gmt = strtotime($item->post_modified_gmt);

		unset($item->guid);

		$item->post_content = apply_filters("the_content", $item->post_content);
		$item->post_excerpt = $this->createExcerpt($item);
		$item->taxonomy = $this->getTerms($item);

		return $item;
	}

	/**
	 * Fill a model's properties with the values
	 * from the given recordset
	 * @param $recordset Object of array of obejcts
	 * @return array
	 */
	protected function hydrate($recordset)
	{
		if (empty($recordset)) {
			return $recordset;
		}

		if (is_array($recordset)) {

			$data = array_map(function($item) {
				$model = ClassFinder::find("Models", ucfirst($item->post_type));
				return new $model($item);
			}, $recordset);

		} else {
			$model = ClassFinder::find("Models", ucfirst($this->object));
			$data = new $model($recordset);
		}

		return array(
			"result" => $data
		);
	}

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

	/**
	 * Gets terms on the given item for all
	 * taxonomies attached to the item's posty type.
	 * @param  object $item Post object
	 * @return array
	 */
	protected function getTerms($item)
	{
		$taxonomies = get_object_taxonomies($item);
		$terms = array();

		foreach ($taxonomies as $taxonomy) {
			$terms[$taxonomy] = wp_get_post_terms($item->ID, $taxonomy);
		}

		return $terms;
	}

	protected function getAttachments($item)
	{
		$args = array(
			"parent" => $item->ID,
			"per_page" => -1,
			"status" => "any"
		);

		$mapper = new AttachmentMapper($args);
		$mapper->findMany();
		
		return $mapper->data["result"];
	}

	protected function getFeaturedImage($item)
	{
		$args = array(
			"id" => get_post_thumbnail_id($item->ID),
			"status" => "any"
		);

		$mapper = new AttachmentMapper($args);
		$mapper->findOne();
		
		return $mapper->data["result"];
	}
}