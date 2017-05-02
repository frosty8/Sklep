<?php
require_once '../Book.php';
require_once '../Album.php';

class ProductManager{
////////////////////////////////// Creating proper type of object ///////////////////////////////////////

	//Isn't it quite difficult for iffs/switches to enable registering of other product types in future?
	public function createProduct($type, $name, $price, $author, $description)
	{
		if ($type == 'Book') {
			return new Book($name, $price, $author, $description);					
		}
		elseif ($type == 'Album') {
			return new Album($name, $price, $author, $description);					
		}

		
		/* Other types - other elses

		.........................................................

		*/

		
		else{
			echo "<br>Nie ma takiego typu produktu.";
			echo "Development info: check the radio input in form/the types of products avalible for adding";
		}
	}

	public function addProductToDb($product){	

		$query = $product->buildQuery(); // Query for adding is a method of $product object 
		//echo $query; 					 // Development info

		$databaseManager = new DatabaseManager();
////////////////////////////////// Print the effect ///////////////////////////////////////
		if ($result = $databaseManager->getFromDatabase($query)){
				echo '<b style="color:#00DD00;">Manager: dodany produkt:</b><br>';		
				echo "<br>Typ: ".$product->getType();
				echo "<br>Nazwa: ".$product->getName();
				echo "<br>Cena: ".$product->getPrice();
				echo "<br>Autor/wykonawca: ".$product->getAuthor();
				echo "<br>Opis:<br>".$product->getDescription()."<br>";
		}
		else
			echo "Nie dodano produktu";
	}
}
?>