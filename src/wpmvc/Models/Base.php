<?php

namespace wpmvc\Models;

abstract class Base
{
	/**
	 * Maps WordPress fields to fields in WPMVC
	 * models, effectivly renaming them.
	 * @var array
	 */
	protected $fieldMap = array();

	/**
	 * Assigns recordset to the model
	 * @param array $recordset
	 */
	public function __construct($recordset)
	{
		foreach($recordset as $key => $value) {

			// get rid of prefixes
			$prefixless = str_replace(array("post_", "term_"), "", $key);

			// if property exists with WP name
			if (property_exists($this, $key)) {
				$this->$key = $value;

			// if property exists with WP name sans prefix
			} else if (property_exists($this, $prefixless)) {
				$this->$prefixless = $value;

			// if property exists in the fieldmap
			} else if (in_array($key, array_keys($this->fieldMap))) {
				$newName= $this->fieldMap[$key];
				$this->$newName = $value;
			}

		}
	}
}