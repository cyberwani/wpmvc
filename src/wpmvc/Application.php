<?php

namespace wpmvc;

class Application
{
    public static $templateEngine;

    public static function setTemplateEngine(\wpmvc\Interfaces\TemplateEngine $templateEngine)
    {
        static::$templateEngine = $templateEngine;
    }
}