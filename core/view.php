<?php

class View {

	// the template html
	private $html;

	// the output html
	private $output;

	// the filepath for the template
	private $filepath;

	// the keys and values inherited to the template
	private $keys = Array();

	// constructor: gets the html
	public function __construct($filename){

		// by getting parsed filepath
		$this->filepath = $this->getRealPath($filename);

		// checking if file exists and saving html within scope
		// as private string $this->html
		if(file_exists($this->filepath)){
			ob_start();
			include $this->filepath;
			$this->html = ob_get_clean();
		} else {
			return false;
		}
	}

	// parse the real filepath 
	private function getRealPath(&$filename){
		$path = explode(".", $filename);
		$newpath = implode("/", $path);
		return '../views/' . $newpath . '.phtml';
	}

	// inject data for the template to use
	public function data($key, $value){
		$this->keys[$key] = $value;
	}

	// Pre-process the quick html tags used
	public function render(){
		$pattern = '/{([^}]*)}/';
		preg_match_all($pattern, $this->html, $matches);

		$totalmatches = count($matches[0]);

		for($i = 0; $i < $totalmatches; $i++){
			$realstring = $matches[0][$i];
			$var = $matches[1][$i];
			$var = str_replace('$', '', $var);
			$this->html = str_replace($realstring, $this->keys[$var], $this->html);	
		}

		echo $this->html;
	}

}