<?php
//Parse config (application.ini) file
global $sConfig;
$sConfig = Swyft_Parseini::parse(APPLICATION_PATH."/configs/application.ini");


//Set up error reporting
ini_set('display_errors',$sConfig->show_errors); 
if($sConfig->show_errors == 1){
error_reporting(E_ALL);
}
 

 
//Autoload Classes
function __autoload($class_name) {
	//Load system files
	if(file_exists(APPLICATION_PATH."/library/Swyft/System/".str_replace("Swyft_","",$class_name) . '.php')){
    	require_once(APPLICATION_PATH."/library/Swyft/System/".str_replace("Swyft_","",$class_name) . '.php');
    }
	//Load models
	else if(file_exists(APPLICATION_PATH."/application/models/".$class_name . '.php')){
    	require_once(APPLICATION_PATH."/application/models/".$class_name . '.php');
    }
    //Load controllers
	else if(file_exists(APPLICATION_PATH."/application/controllers/".$class_name .'.php')){
    	require_once(APPLICATION_PATH."/application/controllers/".$class_name . '.php');
    }
    //Load Main controller
	else if($class_name == "SwyftController"){
    	require_once(APPLICATION_PATH."/library/Swyft/Controller/SwyftController.php");
    }
    //Load libraries
	else if(file_exists(APPLICATION_PATH."/library/Swyft/".$class_name .'.php')){
    	require_once(APPLICATION_PATH."/library/Swyft/".$class_name .'.php');
    }
    
    //Load libraries
	else if(file_exists(APPLICATION_PATH."/library/".$class_name .'.php')){
    	require_once(APPLICATION_PATH."/library/".$class_name .'.php');
    }
    
    //Load libraries
	else if(file_exists(APPLICATION_PATH."/library/Custom/".$class_name .'.php')){
    	require_once(APPLICATION_PATH."/library/Custom/".$class_name .'.php');
    }
    //Load migrations
	else if(file_exists(APPLICATION_PATH."/scripts/migrations/".$class_name .'.php')){
    	require_once(APPLICATION_PATH."/scripts/migrations/".$class_name . '.php');
    }
   	else {
   		echo "An Error Occurred. Class '".$class_name."' not found";
   	}
}

//Connect to Database
Swyft_DB::makeConnection($sConfig->dbhost,$sConfig->dbusername,$sConfig->dbpassword,$sConfig->dbname);

//Check if web application or cli before rendering page
if (PHP_SAPI === 'cli')
{ 
	//CLI-specific logic here
} else {
	//Route to appropriate page
	Swyft_Router::route();
}


