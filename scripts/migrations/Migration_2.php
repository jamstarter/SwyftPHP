<?php


class Migration_2 extends Swyft_DB{

	protected $_name = "test";

	public function up(){
		$this->addColumn('column1')
		->addColumn('column2')
		->addColumn('column3')
		->createTable('test2');	
	}
	
	public function down(){
		$this->dropTable('test2');
	}

}