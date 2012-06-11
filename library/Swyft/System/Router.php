<?php
/**
* The Swyft_Router class is responsible for handling routes for SEO Urls
* Custom routes are set in config/routes.ini
*/
class Swyft_Router{

	/**
	* Intercept and process the current route
	*/
	public function route(){
		if(@$_GET['url'] == ""){
			$url = "/";
		} else {
			$url = $_GET['url'];
		}
		$requestURI = explode('/', $url);
		
		//Parse routes config file
		$routes = Swyft_Parseini::parse(APPLICATION_PATH."/configs/routes.ini");
		$routeList = array();
		foreach($routes AS $key => $value){
			$key = str_replace("routes.","",$key);
			$keySplit = explode(".",$key);
			$routeList[$keySplit[0]][$keySplit[1]] = $value;	
		}
		$urlRoutes = array();
		foreach($routeList AS $r){
			$keySplit = explode("/:",$r['route']);
			$basePath = $keySplit[0];
			$urlRoutes[$basePath] = $r;
		}
		
		//Determine best match for current route
		if (key_exists(@$requestURI[0]."/".@$requestURI[1]."/".@$requestURI[2]."/".@$requestURI[3]."/".@$requestURI[4],$urlRoutes)){
			$myRouteName  = @$requestURI[0]."/".@$requestURI[1]."/".@$requestURI[2]."/".@$requestURI[3]."/".@$requestURI[4];
		} else if (key_exists(@$requestURI[0]."/".@$requestURI[1]."/".@$requestURI[2]."/".@$requestURI[3],$urlRoutes)){
			$myRouteName  = @$requestURI[0]."/".@$requestURI[1]."/".@$requestURI[2]."/".@$requestURI[3];
		} else if (key_exists(@$requestURI[0]."/".@$requestURI[1]."/".@$requestURI[2],$urlRoutes)){
			$myRouteName  = @$requestURI[0]."/".@$requestURI[1]."/".@$requestURI[2];
		} else if (key_exists(@$requestURI[0]."/".@$requestURI[1],$urlRoutes)){
			$myRouteName  = @$requestURI[0]."/".@$requestURI[1];
		} else if(key_exists(@$requestURI[0],$urlRoutes)){
			$myRouteName = @$requestURI[0];
		}
		$myroute = $urlRoutes[$myRouteName];
		
		//Call controller and action
		$controller = ucwords($myroute['controller'])."Controller";
		$action = $myroute['action'];
		
		//Initialize Controller
		$Template = new $controller;
		
		
		//Set View script
		$Template->setView(APPLICATION_PATH."/application/views/".strtolower($myroute['controller'])."/".strtolower($action).".phtml");
		
		//Get leftover variables from route
		$leftover = str_replace($myRouteName,"",$myroute['route']);
		$variables = explode("/",str_replace(":","",$leftover));
		
		//Get leftover values from URL
		$leftover2 = str_replace($myRouteName,"",$url);
		$variables2 = explode("/",str_replace(":","",$leftover2));
		$replaceDefaults = array();
		
		//Match leftovers from route with leftovers from URL
		foreach($variables AS $key => $value){
			$replaceDefaults[$variables[$key]] = @$variables2[$key];
		}
		
		//Replace default values and set in view object
		$replaceDefaults = array_filter($replaceDefaults);
		foreach($myroute AS $key => $value){
			if($key <> 'controller' && $key <> 'action' && $key <> 'route'){
				if(key_exists($key,$replaceDefaults)){
					$Template->view->$key = $replaceDefaults[$key];
				} else {
					$Template->view->$key = $value;
				}
			}
		}

		//Pass variables to view
		$data = array();
		foreach($Template->view AS $viewObj => $value){
			if($viewObj <> 'path'){
				$data[$viewObj] = $value;
				if($viewObj <> 'url'){
				$Template->request->setParam($viewObj,$value);
				}
			}
			
		}
		
		//Run controller action
		$Template->$action();

		//Render the page and process all variables passed in
		$Template->render($Template->view->path,@$Template->view);
		
	}

}