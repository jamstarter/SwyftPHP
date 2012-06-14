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
		foreach(@$_REQUEST AS $key => $value){
			$this->gets[$key] = mysql_real_escape_string($value);
			$this->params[$key] = mysql_real_escape_string($value);
		}
		foreach(@$_GET AS $key => $value){
			$this->gets[$key] = mysql_real_escape_string($value);
			$this->params[$key] = mysql_real_escape_string($value);
		}
		foreach(@$_POST AS $key => $value){
			$this->posts[$key] = mysql_real_escape_string($value);
			$this->params[$key] = mysql_real_escape_string($value);
		}
		
	}
	
	/**
	* Get post data
	*/
	public function getPosts(){
		return $this->posts;
	}
	
	/**
	* Get request data
	*/
	public function getRequests(){
		return $this->gets;
	}
	
	/**
	* Get post and request data
	*/
	public function getParams(){
		return $this->params;
	}
	
	/**
	* Get post data
	* @param $key 
	* @param $default Default value if not set
	*/
	public function getPost($key,$default=null){
		if($this->posts[$key]){
			return $this->posts[$key];
		} else {
			return $default;
		}
	}
	/**
	* Get request data
	* @param $key 
	* @param $default Default value if not set
	*/
	public function getRequest($key,$default=null){
		if($this->gets[$key]){
			return $this->gets[$key];
		} else {
			return $default;
		}
	}
	
	/**
	* Get post and request data
	* @param $key 
	* @param $default Default value if not set
	*/
	public function getParam($key,$default=null){
		if($this->params[$key]){
			return $this->params[$key];
		} else {
			return $default;
		}
		
	}
	
	/**
	* Set a single parameter
	* @param $key key of param
	* @param $value value of param
	*/
	public function setParam($key,$value){
		$this->params[$key] = $value;
	}
	
	/**
	* Set multiple params at once
	* @param $array (array) key=>value data
	*/
	public function setParams($array){
		foreach($array AS $key => $value){
			$this->params[$key] = mysql_real_escape_string($value);
		}
	}
	
	/**
	* Check if post
	*/
	public function isPost(){
		return (!empty($_POST));
	}

}