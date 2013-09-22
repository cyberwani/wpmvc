<?php

namespace wpmvc\Mappers;

use \wpmvc\Helpers\ClassFinder;

class AuthorMapper extends Base
{
	protected $object = "Author";

	/**
	 * Initiates hydration
	 * @param array $options Key/value query options
	 */
	public function __construct($id)
	{
		$this->id = $id;
	}

	public function findOne()
	{
		$userObject = get_userdata($this->id);
		$user = $this->extract($userObject);
		$this->data = $this->hydrate($user);
		$this->wpmvcAddToPayload();
		$this->addToPayload();
		return $this->data;
	}

	/**
	 * Extract properties out of the user object
	 * @param  WP_User $userObject
	 * @return object Object with extracted properties
	 *                from the WP_User object.
	 */
	public function extract($userObject)
	{
		$user = new \StdClass();
		$user->id = $userObject->ID;
		$user->display_name = $userObject->display_name;
		$user->first_name = $userObject->user_firstname;
		$user->last_name = $userObject->user_lastname;
		$user->email = $userObject->user_email;
		$user->url = $userObject->user_url;
		$user->description = $userObject->description;
		return $user;
	}

	protected function hydrate($recordset)
	{
		if (empty($recordset)) {
			$data = $recordset;
		}

		else if (is_array($recordset)) {

			$data = array_map(function($item) {
				$model = ClassFinder::find("Models", ucfirst($item->object));
				return new $model($item);
			}, $recordset);

		} else {
			$model = ClassFinder::find("Models", ucfirst($this->object));
			$data = new $model($recordset);
		}

		return array(
			"results" => $data
		);
	}
}