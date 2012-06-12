<?php
/**
* Swyft controller is the parent to all other controllers
*/

class SwyftController{

	public $view;
	public $request;
	protected $_disableLayout;

	function __construct(){
		$this->db = new Swyft_DB;
		$this->request = new SRequest;

		
	}
	
	/**
	* Set the View for the page
	* @param $filename The name of the view file
	*/
	public function setView($filename){
		$this->view->path = $filename;
		
	}
	
	/**
	* Render the page and process all variables in the view
	* @path path of the file to render
	* @data any variables being passed into the view
	*/
	public function render($path,$data){

		if(!empty($data)){
			foreach($data AS $d => $value){
				$this->$d = $value;
				
			}
		}
		
		if(@$this->_disableView <> 1){
		 	require_once($path);
		 	$swyftPageContent = ob_get_contents();
		 	ob_clean();
		 }
		if(@$this->_disableLayout <> 1){
			
			require_once(APPLICATION_PATH."/application/layouts/default.phtml");
			$completeView = ob_get_contents();
		 	ob_clean();
		 	echo $completeView;
			
		} else {
			if($this->_disableView <> 1){
				echo $swyftPageContent;
			}
		}
	

	}
	
	public function disableLayout(){
		$this->_disableLayout = 1;
		return $this;
	}
	
	public function disableView(){
		$this->_disableView = 1;
		return $this;
	}
	
	public function getConfig(){
		global $sConfig;
		return $sConfig;
	}

}