<?php

//Add to CLI menu
$commands[] = array('command'=>'migrate','description'=>'Migrate Database');

/**
* This function aids in migrating your database to different versions
*/
function migrate($new_version=0){
	echo "Swyft Database Migration \n\n";
	
	//Get Current Version
	$version = Swyft_Parseini::parse(APPLICATION_PATH."/scripts/migrations/migration.ini");
	$current_version = $version->current_version;
	//Get all migration scripts from migrations directory
	$migrations = scandir(APPLICATION_PATH."/scripts/migrations");
	$unset = array('.','..','migration.ini');
	//Filter out unwanted files
	foreach($migrations as $key => $value){
		if(in_array($value,$unset)){
			unset($migrations[$key]);
		}
	}
	//If no new version given, upgrade to highest version
	if(!@$new_version){
		$new_version = count($migrations);
	}
	//Check if we're going up or down
	if($current_version > $new_version){
		$migrations = array_reverse($migrations);
	}
	//Loop through migration scripts
	foreach($migrations AS $migration){
		//Get version for current migration file
		$thisversion = str_replace("Migration_","",str_replace(".php","",$migration));
		//Run migration up or down, depending on which was determined eariler
		if(($current_version < $new_version) && ($thisversion > $current_version)){
			$classname = "Migration_$thisversion";
			$mg = new $classname;
			$mg->up();
			file_put_contents (APPLICATION_PATH."/scripts/migrations/migration.ini", "current_version = $thisversion");
			$current_version++;
		} else if (($current_version > $new_version) && ($thisversion >= $new_version)) {
				$classname = "Migration_".($thisversion+1);
				if(($thisversion+1) < count($migrations)){
				$mg = new $classname;
				$mg->down();
				
				file_put_contents (APPLICATION_PATH."/scripts/migrations/migration.ini", "current_version = ".($thisversion));
				}
				
		}
	}
	//Get current version from migration.ini
	$version = Swyft_Parseini::parse(APPLICATION_PATH."/scripts/migrations/migration.ini");
	$current_version = $version->current_version;
	//Print to command line screen
	echo "Migrated to Version: ". $current_version ."\n\n";
	
	
}