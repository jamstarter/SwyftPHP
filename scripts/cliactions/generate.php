<?php
//This line must be included for your function to appear in the CLI menu
//If you want to incude multiple methods in one file, just add more 
//elements to this array and include your functions below

$commands[] = array('command'=>'generate [name]','description'=>'Generate Model, View and Controller');

//This is your method.

function generate($name){
	$name = strtolower($name);

	$controller_path = APPLICATION_PATH."/application/controllers/".ucwords($name)."Controller.php";
	$model_path = APPLICATION_PATH."/application/models/".ucwords($name).".php";
	$view_path = APPLICATION_PATH."/application/views/".$name."/".$name.".phtml";
	//Set controller text
$controllerText = "<?php
class ".ucwords($name)."Controller extends SwyftController{

	public function ".$name."(){
	
	}
	
	
}
";

$modelText = "<?php
class ".ucwords($name)." extends Swyft_DB{

	protected \$_".$name.";
	
	
}
";
$viewText = "";
if(!is_dir(APPLICATION_PATH."/application/views/".$name)){
	mkdir(APPLICATION_PATH."/application/views/".$name,0777);
}

file_put_contents($controller_path,$controllerText);
file_put_contents($model_path,$modelText);
file_put_contents($view_path,$viewText);
	
}