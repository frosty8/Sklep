<?php
require_once 'BaseProduct.php';
class Album extends BaseProduct
{
	private $artist;  //Do wyrzucenia, albo stworzyć osobne tabele dla każdego typu produktu

	public function getArtist(){
		return $this->artist;
	}
	public function setArtist($author){
		$this->artist = $artist;
	}

	public function __construct($name, $price, $author, $description){
		parent::__construct($name, $price, $author, $description);
		$this->type = "Album";
		$this->artist = $author;//<<-----------------------

	}

	public function __toString(){
		return "Typ: ".$this->getType().". Nazwa: ".$this->getName().". Cena: ".$this->getPrice().".
		Wykonawca: ".$this->getArtist().". Opis: ".$this->getDescription()."<br>";
	}
/////////////////////////// (ADMIN) Query for adding an album product to database ////////////////////////////
//Maybe improve Registrable interface or something to build queries with one method or something something?

	public function buildQuery(){
		$query = "INSERT INTO `products` 
				(`p_ID`, `type`, `name`, `price`,`author`, `artist`,`description`) VALUES 
				(NULL,	'".$this->getType()."',	'".$this->getName()."',	'".$this->getPrice()."',
				NULL,	'".$this->getArtist()."',	'".$this->getDescription()."'	)";

		return $query;
	}
}
?>
