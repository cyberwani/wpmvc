<?php

// Composer autoload
require __DIR__ . "/vendor/autoload.php";

// Setup Router
$adapter = new \RouterExchange\Adapters\Slim(new \Slim\Slim());
$router = new \RouterExchange\Router($adapter);

// Routes
$router->get("/:year/:month/:day/:slug", function ($year, $month, $day, $slug) {
	echo "this is the {$slug} post.";
	
});

$router->get("/:page", function ($page) {
    echo "this is the {$page} page.";
});

$router->run();