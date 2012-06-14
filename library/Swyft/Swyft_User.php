<?php
/**
* Swyft_User lets you interact with user data, create users, log in and log out
*/
class Swyft_User extends Swyft_DB{

	//Set the name of the user table
	protected $_name = "users";
	//Set columns for the user table (id,email,password,salt are given by default)
	protected $_fields = array("address","city","state","zip","country","phone");
	
	/**
	* This function creates migration for the user table and then runs the up() function in the migration
	* This does not change your current migration version
	*/
	public function createUserTable(){
		$migrations = scandir(APPLICATION_PATH."/scripts/migrations");
		$count = count($migrations);
		$next_migration = $count-2;
		$columns = "";
		foreach($this->_fields AS $field){
			$columns .= "->addColumn('".$field."')";		
		}

			$migrationText = "<?php
				class Migration_".$next_migration."{
				
					protected \$_name = '".$this->_name."';
					
					public function up(){
						\$this->addColumn('email')
						->addColumn('password')
						->addColumn('salt')
						$columns
							->createTable('".$this->_name."');
					}
					
					public function down(){
						\$this->dropTable('".$this->_name."');
					}
				}

			";

		file_put_contents(APPLICATION_PATH."/scripts/migrations/Migration_".$next_migration.".php",$migrationText);
		$newClass="Migration_$next_migration";
		$newClass::up();
			
	}
	
	/**
	* Get user object
	* @param $id The id of the user being retrieved
	*/
	public function getUser($id){
		$result = $this->select()
				->from($this->_name)
				->where("id='$id'")
				->fetchObject();
		return $result;		
	}

	/**
	* Authenticate User and Create Session
	* @param $email
	* @param $password
	* @return bool
	*/
	public function login($email,$password){
		$this->select();
		$this->from($this->_name);
		$this->where("email='$email'");
		$user = $this->fetchObject();
		if($user){
				if(@$user->password == sha1(@$password.@$user->salt)){
					$thisUser = $user->id;
				}		
			if(@$thisUser){
				$result = $this->getUser($thisUser);
			} else {
				$result = false;
			}
		}
		if($result){
			$_SESSION['user'] = $result;
			return true;
		} else {
			return false;
		}
	}

	/**
	* Destroy current user session
	*/
	public function logout(){
		$_SESSION['user'] = null;
		unset($_SESSION['user']);
	}
	
	/**
	* Create User Record
	* @param $userinfo (array)
	* @return bool
	*/
	public function createUser($userinfo){
		$data=array();
		foreach($userinfo AS $key => $value){
			$data[$key] = $value;
			if($key == 'password'){
				$data['salt'] = uniqid();
				$data['password'] = sha1($value.$data['salt']);
			}
			
		}
		
		$result = $this->insert($data);
		return $result;
	}
	
	/**
	* Update user record
	* $data (array) user data
	* $where (string) where clause ie. "id='3'"
	*/ 
	public function updateUser($data,$where){
		$this->update($data,$where);
	}
	
	/**
	* Delete a User
	* @param $id User ID
	*/
	public function deleteUser($id){
		$this->delete()
				->from($this->_name)
				->where("id='$id'"); 
		return $this->runQuery();
	}
	
	public function isActive(){
		if(isset($_SESSION['user'])){
			return true;
		} else {
			return false;
		}
	}

}
