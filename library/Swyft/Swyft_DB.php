<?php
/**
* Swyft_DB is used to interact with the database. 
* By default, ithe connection occurs in the bootstrap.
* The database settings are set in application.ini
*/
class Swyft_DB{
	
	protected $_query;
	protected $_where;
	protected $_columns;
	protected $_name;
	
	/**
	* Initialize a connection to a database
	* @param $dbhost database host location or ip
	* @param $dbusername database username
	* @param $dbpassword database password
	* @param $dbname database name
	*/
	public function makeConnection($dbhost,$dbusername,$dbpassword,$dbname){
		mysql_connect($dbhost, $dbusername, $dbpassword);
		mysql_select_db($dbname);
	}
	
	/**
	* Set the table name for the db object
	* @param $table name of table
	*/
	public function setTable($name){
		$this->_name = $table;
	}
	
	/**
	* Add select section to query property
	* @param $what column name/names
	*/
	public function select($what="*"){
		$this->_query = "SELECT $what ";
		return $this;
	}
	
	/**
	* Insert data to DB
	* @param $data array
	*/
	public function insert($data){
		$this->_query = "INSERT INTO ".$this->_name." ";
		$sets = array();
		foreach($data AS $key => $value){
			$sets[]=" $key = \"".mysql_real_escape_string($value)."\" ";
		}
		$this->_query .= "SET ". implode(",",$sets) ." ".$this->_where;
		mysql_query($this->_query);
		return mysql_insert_id();
	}
	
	/**
	* Add from section to query property
	* @param $table database table name
	*/
	public function from($table){
		$this->_query .= "FROM $table ";
		return $this;
	}
	
	/**
	* Add where clause to query property
	* @param $where SQL where clause - can also be chained together
	*/
	public function where($where){
		$clause = "";
		if($this->_where == ""){
			$clause = "WHERE ";
		} else {
			$clause ="AND ";
		}
		$this->_where .=$clause." ".$where." ";
		$this->_query .= $this->_where." ";
		return $this;
	}
	
	/**
	* Fetch data object from Database
	* @return Object results
	*/
	public function fetchObject(){
		$result = mysql_query($this->_query);
		$array = mysql_fetch_assoc($result);
		return (object) $array;
	}
	
	/**
	* Fetch data array from Database
	* @return array results
	*/
	public function fetchArray(){
		$result = mysql_query($this->_query);
		$array = mysql_fetch_assoc($result);
		return $array;
	}
	
	/**
	* Fetch data object from Database
	* @return Object result
	*/
	public function fetchRow(){
		$result = mysql_query($this->_query);
		$array = mysql_fetch_row($result);
		return (object) $array;
	}
	
	/**
	* Dump current query onto the screen
	* @return string
	*/
	public function dumpQuery(){
		echo $this->_query;
	}
	
	/**
	* Add a column - used prior to running createTable()
	* @param $column name of new column
	* @param $type datatype of column
	*/
	public function addColumn($column,$type="varchar(255) "){
		$this->_columns .= $column. " ".$type.",";
		return $this;
	}
	
	/**
	* Create a table in mysql
	* @param $table table name
	*/
	public function createTable($table){
		$query = "CREATE TABLE `".$table."` (`id` int(11) NOT NULL AUTO_INCREMENT, ";
		$query .= $this->_columns;
		$query .="PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;";
		mysql_query($query);
		$this->_columns ="";
		return $this;
	}
	
	
	/**
	* Remove database table
	* @param $table database table name
	*/
	public function dropTable($table){
		$query = "DROP table `$table`";
		mysql_query($query);
		return $this;
	}
	/**
	* run a query that you've previously built
	*/
	public function runQuery(){
		mysql_query($this->_query);
	}
	
	/**
	* Add delete section to query property
	* @where where clause ex. "id='3'"
	*/
	public function delete($where){
		$sql = "DELETE FROM ".$this->_name." WHERE $where";
		return mysql_query($sql);
	}
	
	/**
	* Set query order
	* @param $by order by clause
	*/
	public function order($by){
		$this->_query .= "ORDER BY ".$by." ";
	}
	
	/**
	* Set query limit
	* @param $limit
	*/
	public function limit($limit){
		$this->_query .= "LIMIT ".$limit." ";
	}
	
	/**
	* Update data to DB
	* @param $data array
	*/
	public function update($data,$where){
		$this->_query = "UPDATE ".$this->_name." ";
		$sets = array();
		foreach($data AS $key => $value){
			$sets[]=" `$key` = \"".mysql_real_escape_string($value)."\" ";
		}
		$this->_query .= "SET ". implode(",",$sets) ." WHERE ".$where." ";

		return mysql_query($this->_query);
	}
	
	/**
	* Run raw SQL
	* @param $sql (string) your query
	* @param $return if true, associative array is returned
	*/
	public function runSQL($sql,$return=false){
		$result = mysql_query($sql);
		if($return){
			return mysql_fetch_assoc($result);
		} else {
			return $result;
		}
	}
}