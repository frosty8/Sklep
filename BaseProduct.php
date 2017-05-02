<?php
include 'Registrable.php';
abstract class BaseProduct implements Registrable{
	protected $p_ID;
	protected $type;
	protected $name;
	protected $price;
	protected $author;
	protected $description;


	public function getID(){
		return $this->p_ID;
	}
	public function getType(){
		return $this->type;
	}
	public function getName(){
		return $this->name;
	}
	public function getPrice(){
		return $this->price;
	}
	public function getAuthor(){
		return $this->author;
	}
	public function getDescription(){
		return $this->description;
	}

	public function setType($type){
		$this->type = $type;
	}
	public function setName($name){
		$this->name = $name;
	}
	public function setPrice($price){
		$this->price = $price;
	}
	public function setAuthor($author){
		$this->author = $author;
	}
	public function __setDescription($description){
		$this->description = $description;
	}

	public function __construct($name, $price, $author, $description){
		$this->p_ID = null;
		$this->name = $name;
		$this->price = $price;
		$this->author = $author;
		$this->description = $description;

	}
/////////////////////////// (ADMIN) Query for adding an album product to database ////////////////////////////
//Maybe improve Registrable interface or something to build queries with one method or something something?
	abstract function buildQuery();
}
?>