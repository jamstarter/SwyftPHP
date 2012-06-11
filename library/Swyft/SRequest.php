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
	
	public function getPost($key){
		return $this->posts[$key];
	}
	
	public function getRequest($key){
		return $this->gets[$key];
	}
	
	public function getParam($key){
		return $this->params[$key];
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