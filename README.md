# WordPress MVC (WPMVC)

_If you are looking for something to use in production, this is not it. This project is still mostly experimental._

A PHP framework to use WordPress as a model-view-controller (MVC) system.  Given a set of options, fully extendable controllers take care of gathering, mapping, and formatting post and page data, leaving you with a data set that can be rendered in any PHP templating system.


## Some things to do
* Test Silex adapter thoroughly
* Take meta data out of "meta" property


## Requirements
* WordPress (for the backend)


## Recommended
* [Composer](http://getcomposer.org/), to install dependencies with
* A router library, like [Slim](http://www.slimframework.com/)
* A template library, like [Twig](http://twig.sensiolabs.org/)

Alternatively, you could handle your own routing and use PHP as your templating system. However, for the documentation, I will be using Composer, Slim and Twig.


## Installation

I recommend installing WPMVC through [Composer](http://getcomposer.org/). Once you have Composer installed, create a `composer.json` file in the root of your project, add the following code and run `php composer.phar install` to install.

```json
{
    "require": {
        "jenwachter/wpmvc": "dev-master"
    }
}
```


## Initializing

A few things need to be initialized in order to use WPMVC.

__Bootstrap WordPress__

```php
define("WP_USE_THEMES", false);
require __DIR__ . "/public/wp/wp-blog-header.php";
```

_Keep in mind the path to your `wp-blog-header.php` file may be different. To find it, look in the root of your WordPress installation._


__Set the template engine__

```php
// initialize the engine adapter
$templateDir = __DIR__ . "/app/views";
$template = new \wpmvc\Adapters\TemplateEngines\Twig($templateDir);

// set the enigine in WPMVC
\wpmvc\Application::setTemplateEngine($template);
```


__Set the router engine__

```php
// initialize the engine adapter
$router = new \wpmvc\Adapters\Routers\Slim\Router();

// set the enigine in WPMVC
\wpmvc\Application::setRouter($router);
```

WPMVC is now all setup. Let's get on to the fun stuff.

## Routing
Each route will need to instantiate a controller based on the type of data you're looking for &mdash; post, page, attachment, or a collection or posts, pages, or attachments.

Each controller accepts two optional arguments: an array of options (for example, number of items to return or a taxonomy term to narrow the results by &mdash; see documentation in `Controllers/Base.php` for full details until I can write some more documentation) and a string representing the location of the template to render the data in (see Templating below).

### Collections
The following route creates a collection controller that looks for the five most recent posts. The data is then rendered into the `post` template in the templates directory I indicated when setting up the template engine.

```php
$router->get("/", function() {
    $options = array(
        "per_page" => 5,
        "type" = "post"
    );
    $controller = new \wpmvc\Controllers\CollectionController($options);
});
```


### Post
The following route creates a post controller looking for a post published on the given year, month, day, with the given slug. Since we passed a second parameter indicating that we want to render the data in a different template than the default `post`, the data will render in the template located at `blog/post`.

```php
$router->get("/:year/:month/:day/:slug(/)", function ($year, $month, $day, $slug) {
    $options = compact("year", "month", "day", "slug");
    $controller = new PostController($options, "blog/post");
});
```


### Custom posts types
WPMVC can also handle custom post types. The following route creates a collection controller looking for the five most recent posts of the "project" type. The data is rendered in the template located at `collections/project`.

```php
$router->get("/projects(/)", function() {
    $options = array(
        "per_page" => 5,
        "type" => "project" // my custom post type
    );
    $controller = new CollectionController($options, "collections/project");
});
```


### Page
The following route creates a page controller looking for a page with the given slug. Since we did not pass a second paramter, the found data is rendered in the `page` template.

```php
$router->get("/:slug", function ($slug) {
    $options = array(
        "slug" => $slug
        "type" => "page"
    );
    $controller = new PageController($options);
});
```



## Templating
After the controller gets the data from the mapper, it renders a template with that data. By default, WPMVC loads a template with the name of the controller you called relative to the templates directory set in the template engine adapter. The template adapter takes care of adding the file extension, so pass `templateName` instead of `templateName.twig`.

### Examples

```php
// Load data into the `project` template
$controller = new PostController($options, "project");

// Load data into the `post` template in the `blog` folder
$controller = new PostController($options, "blog/post");
```

After the data is loaded into the template, render the data in the template according to the template engine chosen.



## Extending
WPMVC controllers, mappers, and models are completely extendable and have methods built-in especially for this in mind. __Details to come.__