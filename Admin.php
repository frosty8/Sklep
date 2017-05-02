<?php
require_once 'BaseUser.php';

class Admin extends BaseUser{

	public function __construct($name, $password, $privileges, $adress){
		$this->ID = null;
		$this->name = $name;
		$this->password = $password;
		$this->privileges = 3;
		$this->adress = null;
	}

	public function __toString(){
		return "Admin: ".$this->login.", password: ".$this->password.", privileges: ".$this->privileges."<br>";
	}
	
	public function buildQuery(){
		return "INSERT INTO `users` (`U_ID`, `name`, `password`, `adress`, `privileges`, `rgst_date`) VALUES 
			(NULL, '".$this->name."', '".$this->password."', '', 3, now())";
	}
}
?>
