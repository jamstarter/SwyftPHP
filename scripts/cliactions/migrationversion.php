<?php
//This line must be included for your function to appear in the CLI menu
//If you want to incude multiple methods in one file, just add more 
//elements to this array and include your functions below

$commands[] = array('command'=>'migrationversion','description'=>'Get Current Migration Version for Database');

//This is your method.

function migrationversion(){
	$version = Swyft_Parseini::parse(APPLICATION_PATH."/scripts/migrations/migration.ini");
	$current_version = $version->current_version;
	echo "Current Database Version: ". $current_version ."\n\n";
	//Any logic you want here. All classes from the web application are available here
	
}