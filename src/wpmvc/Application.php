<?php

namespace wpmvc;

class Application
{
    public static $templateEngine;

    public static $appNamespace = "\\";

    public static function setTemplateEngine(\wpmvc\Interfaces\TemplateEngine $templateEngine)
    {
        static::$templateEngine = $templateEngine;
    }

    public static function setAppNamespace($string)
    {
    	static::$appNamespace = rtrim($string, "\\");
    }
}