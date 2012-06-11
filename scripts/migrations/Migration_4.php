<?php


class Migration_4 extends Swyft_DB{

	protected $_name = "downloads";

	public function up(){
		$this->addColumn('downloads')
		->createTable('downloads');	
	}
	
	public function down(){
		$this->dropTable('downloads');
	}

}