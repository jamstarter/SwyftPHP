<?php
//This line must be included for your function to appear in the CLI menu
//If you want to incude multiple methods in one file, just add more 
//elements to this array and include your functions below

$commands[] = array('command'=>'createUserTable','description'=>'Create the User Table for use with Swyft_User class');

//This is your method.

function createUserTable(){
	$users = new Swyft_User;
	$users->createUserTable();
}