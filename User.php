<?php
require_once 'BaseUser.php';

class User extends BaseUser{
	private $adress;

	public function __construct($name, $password, $adress){
		$this->ID = null;
		$this->name = $name;
		$this->password = $password;
		$this->privileges = 0;
		$this->adress = $adress;
	}

	public function __toString(){
		return "User: ".$this->login.", password: ".$this->password.", adress: ".$this->adress."<br>";
	}

	public function buildQuery(){
		return "INSERT INTO `users` (`U_ID`, `name`, `password`, `adress`, `privileges`, `rgst_date`) VALUES 
			(NULL, '".$this->name."', '".$this->password."', '".$this->adress."', 0, now())";
	}
}
?>
