<?php

class Router {

	// Public: get, post, put, delete, all, status, error
	// Private: path, dispatch

	// If a get request
	public static function get($path, $func = null)
	{
		if(page::method() === "GET")
		{
			return self::match($path, $func);
		}
	}

	// If a post request
	public static function post($path, $func = null)
	{
		if(page::method() === "POST")
		{
			return self::match($path, $func);
		}
	}

	// If a put request
	public static function put($path, $func = null)
	{
		if(page::method() === "PUT")
		{
			return self::match($path, $func);
		}
	}

	// If a delete request
	public static function delete($path, $func = null)
	{
		if(page::method() === "DELETE")
		{
			return self::match($path, $func);
		}
	}

	// If all requests apply
	public static function all($path, $func = null)
	{
		self::match($path, $func);
	}

	// A catch-all error request
	public static function error($func = null)
	{
		self::dispatch($func);
	}

	// If request matches header status code
	public static function status($code, $func = null )
	{
		if(page::header() === $code){
			self::dispatch($func);
		}
	}

	private static function wildcard($path, $func){

		// The path from the controller
		$controllerdirs = explode('/', $path);

		// The path from the request
		$pathdirs = explode('/', slug::base());

		// Fail if controllerdirs and pathdirs aren't
		// the same folder depth
		if(count($pathdirs) !== count($controllerdirs)){
			return false;
		}

		// An array that contains the variables and values
		// from the path
		$vars = Array();

		for($i = 0; $i < count($controllerdirs); $i++){
			$contdir = $controllerdirs[$i];
			$pathdir = $pathdirs[$i];

			// If curly braces are found in the contdir
			// then retrieve the matching value
			if(strpos($contdir, '{') !== FALSE){
				$key = trim($contdir, '{}');
				$value = $pathdir;
				$vars[$key] = $value;
			} else if($contdir !== $pathdir) {
				return false;
			}
		}

		self::dispatch($func, $vars);
	}

	// The match function
	private static function match($path, $func){
		if(slug::base() === $path || !slug::base() && $path === "/"){
			self::dispatch($func);
		} else if(strpos($path, "{") !== FALSE) {
			self::wildcard($path, $func);
		}
	}

	// The dispatcher
	private static function dispatch($func, $params = null){
		if(is_null($func)){
			return false;
		}

		if(!is_callable($func) && strpos($func, '@') !== FALSE){
			$functionparts = explode('@', $func);
			$func = $functionparts[0] . '::' . $functionparts[1];
			$file = $functionparts[0];
			\Controller\Allow($file);
		} else {
			return false;
		}

		if(!is_null($params) && is_callable($func)) {
			call_user_func_array($func, $params);
		} else if(is_callable($func)) {
			call_user_func($func);
		} else {
			Throw New Exception("This controller cannot be found");
		}

		die();
	}
}
