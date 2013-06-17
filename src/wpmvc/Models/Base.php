<?php

namespace wpmvc\Models;

abstract class Base
{
	public function __construct($recordset)
	{
		foreach($recordset as $key => $value) {

			$postless = str_replace("post_", "", $key);
			$mapped = array_keys($this->fieldMap);

			if (property_exists($this, $key)) {
				$this->$key = $value;

			} else if (property_exists($this, $postless)) {
				$this->$postless = $value;

			} else if (in_array($key, $mapped)) {
				$newName= $this->fieldMap[$key];
				$this->$newName = $value;
			}

		}
	}
}