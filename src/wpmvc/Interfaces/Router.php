<?php

namespace wpmvc\Interfaces;

interface Router
{
	// Settings
	public function setDebug($boolean);

	// HTTP methods
	public function get($pattern, $callable);
	public function post($pattern, $callable);
	public function put($pattern, $callable);
	public function delete($pattern, $callable);
	public function options($pattern, $callable);

	// Router helpers
	public function redirect($url);
	public function abort($code, $message);

	// Error reporting
	public function error($callable);

	// Run the router
	public function run();
}