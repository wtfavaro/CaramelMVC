<?php

class RootController extends \Controller\Base {
	public static function get(){
    page::header(200);
  	echo Response::json(array("hello" => "world"));
  }
}
