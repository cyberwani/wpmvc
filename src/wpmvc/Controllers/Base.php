<?php

namespace wpmvc\Controllers;

use \wpmvc\Application;

abstract class Base
{
	/**
	 * Template
	 * @var string
	 */
	protected $template;

	/**
	 * Name of model to instantiate; defined
	 * in child classes. 
	 * @var string
	 */
	protected $modelName;

	/**
	 * Model instantiated by controller.
	 * @var object
	 */
	protected $model;

	/**
	 * Sets template and instantiates the model.
	 * @param array  $options  Key/value query options
	 * @param string $template Absolute location of template.
	 * @return null
	 *
	 * Available options:
	 *
	 * author {mixed}   	Retrieves content written by an author or authors.
	 * 						Pass the ID or "nice" name to retrieve content by
	 * 						one author. Pass an array of IDs or "nice" names to
	 * 						retrieve content by multiple athors. "OR" logic is used.
	 *
	 * category {mixed} 	Retrieves content attached to a catagory or categories.
	 * 						Pass the ID or slug of a category to retrieve content in
	 * 					 	one category. Pass an array of IDs or slugs to retrieve
	 * 					  	content in multuple categories. "OR" logic is used.
	 *
	 * day {int}			Retrieves content published on a specific day of the month
	 * 						(1-31).
	 *
	 * id {int}				Post or page ID.
	 *
	 * month {int}			Retrieves content published during a specific month (1-12)
	 * 
	 * order {string}		Sets the ascending or descending order of the results
	 * 						by the order_by parameter. Value passed is either "ASC"
	 * 						or "DESC" and defaults to "DESC."
	 *
	 * order_by {string}	Field by which to order the results. Look to the WP_Queru
	 * 						list of availalbe options for passable values:
	 * 						https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
	 * 
	 * page {int}       	Combined with per_page, creates an offset. Default: 1.
	 * 
	 * pagination {boolean} Whether or not to paginate the results. If set to false,
	 * 						all results are returned. Default: TRUE
	 *
	 * path {string}		Page path. Example: "/services/development/about"
	 * 						
	 * permission {string}  User permission
	 * 
	 * per_page {int}   	The number of content items to retrieve. Default: 10.
	 * 							
	 * sticky {boolean} 	Whether or not to ignore sticky posts. Ignoring sticky
	 * 						posts will not cause the posts to be excluded from the
	 * 						results, but it will cause the posts not to show up in
	 * 						the beginning of the results. Default: TRUE (do not
	 * 						ignore sticky posts).
	 * 					
	 * tag {mixed}      	Retrieves content attached to a tag or tags. Pass
	 * 						the ID or slug of a tag to retrieve content in one
	 * 						tag. Pass an array of IDs or slugs to retrieve content
	 * 						in multuple tags. "OR" logic is used.
	 * 
	 * time {mixed}			Returns content published on a specific date (string "YYYY-MM-DD")
	 * 						or in a date range (array("YYYY-MM-DD", "YYYY-MM-DD"))
	 *
	 * slug {string}		Post slug. Example: "designing-apis"
	 *
	 * type {string}    	The type of content to retrieve -- either "post" or
	 * 						"page." It is only necessary to use this option
	 * 					 	when looking for a collection of pages as it defaults
	 * 					  	to "post."
	 *
	 * year {int}			Retrieves content published during a specific year (YYYY)
	 *
	 * {taxonomy} {string}	Retrieves content attached to a term or terms in a custom
	 * 						taxonomy. Pass the slug of the taxonomy as the option key
	 * 						and the ID or slug of a term to retrieve content in one
	 * 						term. Pass an array of IDs or slugs to retrieve content
	 * 						in multuple terms. "OR" logic is used.
	 * 
	 */
	public function __construct($options = array(), $template = null)
	{
		if ($template) {
			$this->template = $template;
		}

		$model = Application::$appNamespace . "\\Models\\{$this->modelName}";
		
		if (class_exists($model)) {
			$this->model = new $model($options);
		} else {
			$model = "\\wpmvc\\Models\\{$this->modelName}";
			$this->model = new $model($options);
		}
	}

	/**
	 * Renders the content using the designated template
	 * and data obtained by the model.
	 * @return null
	 */
	protected function render()
	{
		$engine = Application::$templateEngine;
		$engine->render($this->template, $this->model->data);
	}
}