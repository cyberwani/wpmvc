<?php

namespace wpmvc\Adapters\TemplateEngines;

class Twig implements \wpmvc\Interfaces\TemplateEngine
{
	/**
	 * Twig environment
	 * @var object
	 */
	protected $twig;

	/**
	 * Initalize the Twig environment and template loader.
	 * @param string $templatesDir Path to templates
	 * @param array  $options  Options to pass to Twig Environment
	 */
	public function __construct($templatesDir, $options = array())
	{
		$loader = new \Twig_Loader_Filesystem($templatesDir);
		$this->twig = new \Twig_Environment($loader, $options);
	}

	/**
	 * Displays the given template with the given data.
	 * @param  string $path Path to Twig template.
	 * @param  array $data  Array of data to pass to the template.
	 * @return null
	 */
	public function render($path, $data)
	{
		$template = $this->twig->loadTemplate($path . ".twig");
		$template->display($data);
	}
}