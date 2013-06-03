<?php

namespace wpmvc\Interfaces;

interface TemplateEngine
{
	public function render($path, $data);
}