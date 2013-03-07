<?php

namespace app\Models;

class Base
{
	public $data;
	protected $options;
	
	public function __construct($options)
	{
		$this->options = $options;

		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}
}