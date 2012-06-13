<?php

class Swyft_Toolbelt{

	/**
	* Validate whether an email address is valid
	* @param $email (string) email address
	*/
	public function isEmail($email){
		$regex = '/^[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*@[a-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,3})$/'; 
		
		//validate that an email address is in proper format
		if(!preg_match($regex, $email)){
			return false;
		}
		return true;
	}
	
	/**
	* Encrypt a string
	*/
	public function stringEncrypt($data){
		return urlencode(base64_encode($data));
	}

	/**
	* Decrypt a string
	*/
	public function stringDecrypt($data){
		return base64_decode(urldecode($data));
	}
	
	/**
	* Generate seo friendly string
	*/
	function makeSlug($string) {
	    //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
	    $string = strtolower(substr($string,0,200));
	    
	    //Strip any unwanted characters
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    
	    //Clean multiple dashes or whitespaces
	    $string = preg_replace("/[\s-]+/", " ", $string);
	    
	    //Convert whitespaces and underscore to dash
	    $string = preg_replace("/[\s_]/", "-", $string);
	    
	    return $string;
	}
}