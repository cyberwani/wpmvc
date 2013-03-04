<?php

// Composer autoload
require __DIR__ . "/vendor/autoload.php";

// Bootstrap WordPress
define("WP_USE_THEMES", false);
require __DIR__ . "/public_html/wp/wp-blog-header.php";

// Routing
$router = new \RouterExchange\Adapters\Slim(new \Slim\Slim());
require __DIR__ . "/config/routes.php";
$router->run();