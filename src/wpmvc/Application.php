<?php

namespace wpmvc;

class Application
{

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