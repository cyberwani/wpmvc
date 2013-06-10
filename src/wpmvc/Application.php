<?php

namespace wpmvc;

class Application
{
    /**
     * Router object
     * @var \wpmvc\Interfaces\Router
     */
    public static $router;

    /**
     * Template engine object
     * @var \wpmvc\Interfaces\TemplateEngine
     */
    public static $templateEngine;

    /**
     * User-end app namespace
     * @var string
     */
    public static $appNamespace = "\\app";

    /**
     * Set the router to the application so methods,
     * such as notFound(), can be used within WPMVC.
     * @param \wpmvc\Interfaces\Router $router Router adapter
     */
    public static function setRouter(\wpmvc\Interfaces\Router $router)
    {
        static::$router = $router;
    }

    /**
     * Set te template engine to the applicaton so methods,
     * such as render(), can be used within WPMVC.
     * @param \wpmvc\Interfaces\TemplateEngine $templateEngine Template engine adapter
     */
    public static function setTemplateEngine(\wpmvc\Interfaces\TemplateEngine $templateEngine)
    {
        static::$templateEngine = $templateEngine;
    }

    /**
     * Set namespace of user-end application so controllers and models
     * can be created to extend the base WPMVC ones.
     * @param sting $string Namespace (like "\\app")
     */
    public static function setAppNamespace($string)
    {
    	static::$appNamespace = rtrim($string, "\\");
    }
}