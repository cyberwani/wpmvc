# WordPress MVC (WPMVC)

A framework for using WordPress as a model-view-controller application. __Note: This project and its documentation are still under active development, so use in production with extreme caution.__

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


## Documentation

[Read the full documentation](http://jenwachter.com/projects/wpmvc/).


## Some things still to do

* How does WPMVC interact with WordPress permalinks
* Make extendability easier
* Implement [data stitching](http://webadvent.org/2011/a-stitch-in-time-saves-nine-by-paul-jones)
* TEST


## Changelog

No official releases as of yet.
