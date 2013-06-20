<?php

namespace wpmvc\Helpers;

use \wpmvc\Application;

class ClassFinder
{
	protected static $addGroup = array(
		"Mappers", "Controllers"
	);

	/**
	 * Find the right class to call; either the user's class
	 * that extends one of WPMVC's or the origin WPMVC class.
	 * @param  string $group Group of classes to look in
	 * @param  string $name  Name of the class
	 * @return string Path to class to use
	 */
	public static function find($group, $name)
	{
		$class = Application::$appNamespace . "\\{$group}\\{$name}";

		if (!class_exists($class)) {
			$class = "\\wpmvc\\{$group}\\{$name}";
		}
		return $class;
	}
}