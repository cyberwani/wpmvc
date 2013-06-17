<?php

namespace wpmvc\Mappers;

use \wpmvc\Application;

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
	// public $data;
	
	/**
	 * Saves passed options to the model.
	 * @param array $options Key/value query options
	 */
	public function __construct($options)
	{
		$this->prepareOptions($options);		
	}

	protected function hydrate($recordset)
	{
		// print_r($recordset); die();
		
		if (is_array($recordset)) {
			// hydrate collection or objects
		} else {
			$objectModel = Application::$appNamespace . "\\Models\\{$this->object}";
			if (!class_exists($objectModel)) {
				$objectModel = "\\wpmvc\\Models\\{$this->object}";
			}
			return new $objectModel($recordset);
		}
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

		if (empty($results)) {
			Application::$router->notFound();
		}

		$this->mapExtraData($results);

		return $results;
	}

	/**
	 * Used by models looking for one result.
	 * @return $this
	 */
	public function findOne()
	{
		$recordset = array_shift($this->find());
		return $this->hydrate($recordset);

		// hydrate
		// get hydrated object

		// $pager = new \wpmvc\Helpers\Pager(array(
		// 	"id" => $this->data["results"]->ID
		// ));
		// $this->data["pagination"] = $pager->paginate();
		
		// return $this;
	}

	/**
	 * Used by models looking for many results.
	 * @return $this
	 */
	public function findMany()
	{
		$recordset = $this->find();
		return $this->hydrate($recordset);

		// hydrate
		// get hydrated object

		// $pager = new \wpmvc\Helpers\Pager(array(
		// 	"totalPages" => $this->query->getTotalPages(),
		// 	"currentPage" => $this->query->getCurrentPage()
		// ));
		// $this->data["pagination"] = $pager->paginate();

		// return $this;
	}

	protected function mapExtraData($results)
	{
		return array_map(function($item) {
			return $this->addDataToResult($item);
		}, $results);
	}

	protected function addDataToResult($item)
	{
		$item->post_date = strtotime($item->post_date);
		$item->post_date_gmt = strtotime($item->post_date_gmt);
		$item->post_modified = strtotime($item->post_modified);
		$item->post_modified_gmt = strtotime($item->post_modified_gmt);

		unset($item->guid);

		$item->post_excerpt = $this->createExcerpt($item);
		$item->taxonomy = $this->getTerms($item);
		$item->attachments = $this->getAttachments($item);
		$item->featuredImage = $this->getFeaturedImage($item);
		
		return $item;
	}

	/**
	 * If an except doesn't exist already,
	 * one is created. 
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
		return get_children(array(
			"post_parent" => $item->ID,
			"post_type"   => "attachment", 
		    "numberposts" => -1,
		    "post_status" => "any"	
		));
	}

	protected function getFeaturedImage($item)
	{
		$id = get_post_thumbnail_id($item->ID);
		return get_post($id);
	}
}