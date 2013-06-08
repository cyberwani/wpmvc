<?php

namespace wpmvc\Interfaces;

interface Route
{
	// Route methods
	public function name($name);
	public function condition($param, $regex);

	// Middleware
	public function before($callable);
	public function after($callable);
}