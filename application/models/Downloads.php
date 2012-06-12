<?php

class Downloads extends Swyft_DB{

	protected $_name = "downloads";
	
	public function addDownload(){
		$downloads = $this->select('downloads')
		->from($this->_name)
		->fetchObject();

		$data=array();
		$data['downloads'] = $downloads->downloads + 1;
		$where = "id='4'";
		$result = $this->update($data,$where);

	}
	
	public function getDownloads(){
		$dl = $this->select('downloads')
		->from($this->_name)
		->fetchObject();
		return $dl->downloads;
	}

}