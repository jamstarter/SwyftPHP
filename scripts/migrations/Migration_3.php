<?php


class Migration_3 extends Swyft_DB{

	protected $_name = "test";

	public function up(){
		$data['column1'] = "three";
		$this->update($data,"id=8");	
	}
	
	public function down(){
		$data['column1'] = "two";
		$this->update($data,"id=8");
	}

}