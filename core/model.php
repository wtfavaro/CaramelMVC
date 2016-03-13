<?php

namespace Model;

function Allow($class){
	$filename = $class . "Model.php";
	include_once "../models/$filename";
}