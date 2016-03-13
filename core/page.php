<?php

class page {

	// Get or set the request method
	public static function method($type = null){
		if(is_null($type)){
			return $_SERVER['REQUEST_METHOD'];
		} else {
			$_SERVER["REQUEST_METHOD"] = $type;
		}
	}

	// Get or set $_POST variables
	public static function post($property, $value=null){
		if (isset($_POST[$property]))
		{
			return $_POST[$property];
		}
    
		return false;
	}

	// Get or set $_GET variables
	public static function get($property, $value=null){
		if(isset($_GET[$property]))
		{
			return $_GET[$property];
		}

		return false;
	}

	// Change the browser location
	public static function location($url){
		header("Location: $url");
	}

	// Quickly set a cookie
	public static function cookie($name, $value = NULL, $time = NULL ){

		// If time isn't set it defaults to approximately a year
		if (is_null($time)) {
			$time = time() + (365 * 24 * 60 * 60);
		}

		if (!isset($_COOKIE[$name])) {
			if (is_null($value)) {
				return false;
			}
		}

		if (isset($_COOKIE[$name])) {
			if (is_null($value)) {
				return $_COOKIE[$name];
			}
		}

		return setcookie($name, $value, $time, "/");
	}

	// Quickly get/set a session var
	public static function session($key, $value = NULL){
		if (isset($_SESSION[$key]) && is_null($value)) {
			return $_SESSION[$key];
		}

		if (!is_null($value)) {
			$_SESSION[$key] = $value;
			return true;
		}

		return false;
	}

	// Change or view header
	public static function header($code = null){
		if(!is_null($code)){
			http_response_code($code);
			return true;
		} else {
			return http_response_code();
		}
	}

}
