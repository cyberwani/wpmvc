<?php

namespace wpmvc\Adapters\TemplateEngines;

class JSON implements \wpmvc\Interfaces\TemplateEngine
{
	protected $baseDir;

	public function __construct($baseDir = "")
	{
		$this->baseDir = $baseDir;
	}

	/**
	 * Displays the data in JSON
	 * @param  string $path Path to template (irrelevant for JSON)
	 * @param  array $data  Array of data to pass to the template.
	 * @return null
	 */
	public function render($path, $data)
	{
		header("Content-type: application/json");
		die(json_encode($data));
	}
}