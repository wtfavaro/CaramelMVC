<?php

// In the case of multiple header requests
// flush the header
header_remove();

// Set the header to allow cross-origin requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

// Test Controller
Router::get('/', 'RootController@get');

/* It's good practice to set up an error route */
Router::error(function(){
	echo Response::json(array("id" => "error", "message" => "This page could not be found."));
	page::header(500);
});
