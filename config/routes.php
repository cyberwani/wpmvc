<?php

$router->get("/", function() {
	$controller = new \app\Controllers\PageController(array("home"));
});

$router->get("/:year/:month/:day/:slug", function ($year, $month, $day, $slug) {
	$options = compact("year", "month", "day", "slug");
	$controller = new \app\Controllers\PostController($options);
	
});

$router->get("/:slug+", function ($slug) {
	$options = compact("slug");
    $controller = new \app\Controllers\PageController($options);
});