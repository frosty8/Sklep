<?php
require_once 'BaseProduct.php';
class Book extends BaseProduct
{
	private $writer; //Do wyrzucenia, albo stworzyć osobne tabele dla każdego typu produktu

	public function getWriter(){
		return $this->writer;
	}
	public function setWriter($writer){
		$this->writer = $writer;
	}

	public function __construct($name, $price, $author, $description){
		parent::__construct($name, $price, $author, $description);
		$this->type = "Book";
		$this->writer = $author;//<<-----------------------
	}

	public function __toString(){
		return "Typ: ".$this->getType().". Nazwa: ".$this->getName().". Cena: ".$this->getPrice().".
		Autor: ".$this->getWriter().". Opis: ".$this->getDescription()."<br>";
	}
/////////////////////////// (ADMIN) Query for adding an album product to database ////////////////////////////
//Maybe improve Registrable interface or something to build queries with one method or something something?

	public function buildQuery(){
		$query = "INSERT INTO `products` 
				(`p_ID`, `type`, `name`, `price`,`author`, `artist`,`description`) VALUES 
				(NULL,	'".$this->getType()."',	'".$this->getName()."',	'".$this->getPrice()."',
				'".$this->getWriter()."'	,NULL ,	'".$this->getDescription()."'	)";

		return $query;
	}
}

?>