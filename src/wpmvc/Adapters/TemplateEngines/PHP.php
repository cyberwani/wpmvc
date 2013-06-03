<?php

namespace wpmvc\Adapters\TemplateEngines;

class PHP implements \wpmvc\Interfaces\TemplateEngine
{
	protected $baseDir;

	public function __construct($baseDir = "")
	{
		$this->baseDir = $baseDir;
	}

	/**
	 * Displays the given template with the given data.
	 * @param  string $path Path to Twig template.
	 * @param  array $data  Array of data to pass to the template.
	 * @return null
	 */
	public function render($path, $data)
	{
		$data = $data;
		include $this->baseDir . $path . ".php";
	}
}