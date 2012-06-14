<?php
/**
* Handle incoming requests
*/
class SRequest{

	public $params;
	public $posts;
	public $gets;

	/**
	* Retrieve request data and organize
	*/
	function __construct(){
		foreach(@$_POST AS $key => $value){
			$this->posts[$key] = mysql_real_escape_string($value);
			$this->params[$key] = mysql_real_escape_string($value);
		}
		foreach(@$_GET AS $key => $value){
			$this->gets[$key] = mysql_real_escape_string($value);
			$this->params[$key] = mysql_real_escape_string($value);
		}
		
		foreach(@$_REQUEST AS $key => $value){
			$this->gets[$key] = mysql_real_escape_string($value);
			$this->params[$key] = mysql_real_escape_string($value);
		}
		
	}
	
	public function getPosts(){
		return $this->posts;
	}
	
	public function getRequests(){
		return $this->gets;
	}
	
	public function getParams(){
		return $this->params;
	}
	
	public function getPost($key,$default=null){
		if($this->posts[$key]){
			return $this->posts[$key];
		} else {
			return $default;
		}
	}
	
	public function getRequest($key,$default=null){
		if($this->gets[$key]){
			return $this->gets[$key];
		} else {
			return $default;
		}
	}
	
	public function getParam($key,$default=null){
		if($this->params[$key]){
			return $this->params[$key];
		} else {
			return $default;
		}
		
	}
	
	public function setParam($key,$value){
		$this->params[$key] = $value;
	}
	
	public function setParams($array){
		foreach($array AS $key => $value){
			$this->params[$key] = mysql_real_escape_string($value);
		}
	}

}