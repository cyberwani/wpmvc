<?php

namespace wpmvc;

class Application
{
    public static $templateEngine;

    public static $appNamespace = "\\";

    public static $router;

    public static function setTemplateEngine(\wpmvc\Interfaces\TemplateEngine $templateEngine)
    {
        static::$templateEngine = $templateEngine;
    }

    public static function setAppNamespace($string)
    {
    	static::$appNamespace = rtrim($string, "\\");
    }

    public static function setRouter(\wpmvc\Interfaces\Router\Router $router)
    {
        static::$router = $router;
    }
}