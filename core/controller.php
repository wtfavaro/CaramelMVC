<?php

namespace Controller;

function Allow($class){
	include_once "../controllers/$class.php";
}

class Base {
	public static function forswitch(&$array, $needle, $function){
		if(is_array($array)){
			foreach($array as $key => &$row){
				if(is_array($row)){
					foreach($row as $lkey => $lvalue){
						if($lkey == $needle){
							$function($row[$lkey]);
						}
					}
				} else {
					if($key == $needle){
						$function($row);
					}
				}
			}
		}
	}
}