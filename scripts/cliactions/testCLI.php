<?php
//This line must be included for your function to appear in the CLI menu
//If you want to incude multiple methods in one file, just add more 
//elements to this array and include your functions below

$commands[] = array('command'=>'testCLI','description'=>'Test the CLI configuration');

//This is your method.

function testCLI(){
	echo "\n\n CLI APPLICATION IS WORKING!!! \n\n";
	
	//Any logic you want here. All classes from the web application are available here
	
}