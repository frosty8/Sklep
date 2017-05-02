<?php
require_once '../Controllers/SessionController.php';
require_once '../Controllers/DatabaseManager.php';
require_once '../Controllers/ViewController.php';

////////////////////////////////// Session timer //////////////////////////////////
session_start();
if(isset($_SESSION['login'])){
	$sessionController = new SessionController();
	$sessionController->checkSessionTime($_SESSION['sessionStart']);
}
// No redirect. Available for every user
////////////////////////////////// Navigation Bar //////////////////////////////////
$viewController = new ViewController();
echo $viewController->getPageHead("Produkt");
echo $viewController->getNavBar();
/////////////////////////////////////// Preview a product ///////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
$query = "SELECT name, price, author, artist, description FROM `products` WHERE `p_ID` LIKE ".$_GET['p_ID'];
$databaseManager = new DatabaseManager();

if ($result = $databaseManager->getFromDatabase($query)){

	$row = $result->fetch_assoc(); 

	$name = $row['name'];
	$price = $row['price'];
	$author = $row['author'];
	$artist = $row['artist'];
	$description = $row['description'];

	echo "<h2>".$name."</h2>";
	if ($artist) {echo "Wykonawca/zespół: ".$artist."<br>";}
	if ($author) {echo "Autor: ".$author."<br>";}
	echo "<h4>Cena: ".str_replace(".", ",", number_format($price,2))." PLN</h4>";
	echo $description."<br><br><br>";

///////////////////////////////////// Throw to the basket - Button //////////////////////////////////
	if (isset($_SESSION['login']) && $_SESSION['privileges']<3) {
		echo 
		'<form method="post" action="basket.php?p_ID='.$_GET['p_ID'].'">
			Ilość:<br>
			<input type="number" name="quantity" value="1" min=1><br><br>
			<input class="tile1" type="submit" value="Dodaj do koszyka">	
		</form>';
	}			
} 
$result->free_result();
?>
	<div style="clear:both;"></div>
	<h4><a href="./produkty.php" class="linkBack">Powrót</a></h4>
</body>
</html>
