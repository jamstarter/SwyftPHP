<?php

class DocsController extends SwyftController{

	public function index(){
	
		$this->view->pageTitle = "Documentation";

	}
	
	public function creatingpages(){
		$this->view->pageTitle = "Creating Pages";
	}
	
	public function database(){
		$this->view->pageTitle = "Interacting with Your Database";
	}
	
	public function requests(){
		$this->view->pageTitle = "Handling Requests";
	}
	
	public function cli(){
		$this->view->pageTitle = "Command Line Interface";
	}
	
	public function migrations(){
		$this->view->pageTitle = "Database Migrations";
	}
	
	


}