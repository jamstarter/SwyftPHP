<?
define("APPLICATION_PATH",dirname(dirname(__FILE__)));
require_once(APPLICATION_PATH."/library/Swyft/System/Bootstrap.php");


$commands = array();
$actions = scandir(APPLICATION_PATH."/scripts/cliactions");

foreach($actions AS $filename){
	if($filename <> '.' && $filename <> '..'){
		include_once APPLICATION_PATH."/scripts/cliactions/".$filename;
	}
}

//Run function or provide help
if(count($argv) > 2){
	$argv[1]($argv[2]);
}
else if(count($argv) > 1){
    $argv[1]();
} else {
   echo "
   
 ____                           ___  __        ____    __  __  ____    
/\  _`\                       /'___\/\ \__    /\  _`\ /\ \/\ \/\  _`\  
\ \,\L\_\  __  __  __  __  __/\ \__/\ \ ,_\   \ \ \L\ \ \ \_\ \ \ \L\ \
 \/_\__ \ /\ \/\ \/\ \/\ \/\ \ \ ,__\\ \ \/     \ \ ,__/\ \  _  \ \ ,__/
   /\ \L\ \ \ \_/ \_/ \ \ \_\ \ \ \_/ \ \ \_    \ \ \/  \ \ \ \ \ \ \/ 
   \ `\____\ \___x___/'\/`____ \ \_\   \ \__\    \ \_\   \ \_\ \_\ \_\ 
    \/_____/\/__//__/   `/___/> \/_/    \/__/     \/_/    \/_/\/_/\/_/ 
                           /\___/                                      
                           \/__/                                          
   
   
\033[32m CLI Command Line Interface for Swyft PHP \033[0m
 Author: Brandon Swift 2012\n
 Available Methods: \n";
   
   
   foreach($commands AS $command){
       echo " \033[34m".$command['command'] ."\033[0m - ". $command['description']."\n";
   }
   echo "\n\n";
}
