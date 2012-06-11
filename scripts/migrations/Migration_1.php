<?php


class Migration_1 extends Swyft_DB{

	protected $_name = "test";

	public function up(){
		$data['column1'] = "one";
		$this->update($data,"id=8");	
	}
	
	public function down(){
		$data['column1'] = "zero";
		$this->update($data,"id=8");
	}

}