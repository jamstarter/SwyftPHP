<?php

class IndexController extends SwyftController{


	function index(){
		
		$this->view->version = "1.1";
		
		

	}
	
	function login(){
		if($this->_users->isActive()){
			$this->redirect("/");
		}
		if($this->request->isPost()){
			$posts = $this->request->getPosts();
			$userid = $this->_users->login($posts['email'],$posts['password']);
			if($userid){
				$this->redirect("/");
			} else {
				echo "Invalid Login. Please try again.";
			}
		}

		
	}
	
	
	public function logout(){
		$this->disableView();
		$this->_users->logout();
		$this->redirect("/login");
	}


}