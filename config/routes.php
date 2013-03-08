<?php

$router->get("/", function() {

	$controller = new \app\Controllers\CollectionController(array(
		"time" => array(
			"2013-02-04",
			"2013-02-17"
		)
	));

	/**
	 * Still need a way to:
	 * exclude authors
	 * exculude tags
	 * exclude categories
	 * query a non-built in taxonomy
	 * custom fields
	 * @var array
	 */
	$options = array(
		"author",				// int or array of ints
		"tag",					// int or array of ints
		"category",				// int or array of ints
		"type",					// "post" (default) or "page"
		"per_page",				// int
		"page",					// int
		"pagination",			// boolean
		"order",				// string
		"order_by",				// string
		"sticky",				// boolean -- or more options?
		"time",					// string or array (range)
		"permission"			// string
	);

});

$router->get("/:year/:month/:day/:slug", function ($year, $month, $day, $slug) {
	$options = compact("year", "month", "day", "slug");
	$controller = new \app\Controllers\PostController($options);
	
});

$router->get("/:slug+", function ($slug) {
	$options = compact("slug");
    $controller = new \app\Controllers\PageController($options);
});