<?php

namespace wpmvc\Interfaces;

interface Router
{
	public function __get($field);
	public function __call($method, $args);

	public function error($callable);
	public function notFound($callable);
}