# WordPress MVC (WPMVC)

Interested in using WordPress for the backend of a website, but not so much for the frontend? WPMVC is a framework to use WordPress as a model-view-controller (MVC) application, separating logic from presentation.
Note: This project and its documentation are still under active development, so use in production with extreme caution.

## Requirements

1. PHP >= 5.3
1. WordPress installed


## Recommended
* A router engine, like [Slim](http://www.slimframework.com/)
* A template engine, like [Twig](http://twig.sensiolabs.org/)


## Installation

The recommended method of installation is via [Composer](http://getcomposer.org/) as it will take care of autoloading WPMVC for you. Simply include the following in a `composer.json` file in the root of your project and run `composer update` from the command line.

{% highlight javascript %}
{
    "require": {
        "jenwachter/wpmvc": "dev-master"
    }
}
{% endhighlight %}

Or, if you want to do your own thing, you can find the [repo on GitHub](https://github.com/jenwachter/wpmvc).


## Changelog

No official releases as of yet.