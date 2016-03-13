<?php

class Response {
	public static function json($keypairs = null, $error = null, $data = Array()){
		// push onto the data array if keypairs has any rows
		if(!is_null($keypairs) && count($keypairs) > 0 && is_array($keypairs))
			$data = $keypairs;

		// determine the response string
		if(count($data) === 0 && $keypairs !== true)
			$data['id'] = 'error';
		else if(count($data) === 0 && $keypairs === true)
			$data['id'] = 'success';

		// add the custom error message if there is one
		if(!is_null($error) && isset($data['id']))
			$data['message'] = $error;

		// modify the header content-type
		header('Content-Type: application/json; charset=utf-8');

		return json_encode($data);
	}

	public static function json2($status, $message){
		header('Content-Type: application/json; charset=utf-8');

		$response = json_encode(array("id" => "error", "message" => "The status code was erroneous, expecting BOOLEAN"));

		switch($status){
			case true:
				$response = json_encode(array("id" => "success", "message" => $message));
				break;
			case false:
				$response = json_encode(array("id" => "error", "message" => $message));
				break;
		}

		echo $response;
		die;
	}
}
