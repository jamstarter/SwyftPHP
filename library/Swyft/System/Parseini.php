<?php

class Swyft_Parseini{

	public function parse($filename){
		$array = parse_ini_file($filename, true, INI_SCANNER_NORMAL );
		return (object) $array;
	}

}