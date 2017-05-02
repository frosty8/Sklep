<?php
require_once 'Registrable.php';
abstract class BaseUser implements Registrable{
	protected $ID;
	protected $name;
	protected $password;
	protected $privileges;

	public function getID(){
		return $this->ID;
	}
	public function getname(){
		return $this->name;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getPrivileges(){
		return $this->privileges;
	}

	public function setName($name){
		$this->name = $name;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	public function setPrivileges($privileges){
		$this->privileges = $privileges;
	}
}
?>