<?php
require_once '../Controllers/SessionController.php';
require_once '../Controllers/ViewController.php';
require_once '../Controllers/ProductManager.php';
require_once '../Controllers/DatabaseManager.php';
////////////////////////////////// Session timer //////////////////////////////////
session_start();
if(isset($_SESSION['login'])){
	$sessionController = new SessionController();
	$sessionController->checkSessionTime($_SESSION['sessionStart']);
}
else{
	header('Location:index.php');
	exit();	
}
////////////////////////////////// Navigation Bar //////////////////////////////////
$viewController = new ViewController();
echo $viewController->getPageHead("Zamówienie");
echo $viewController->getNavBar();
////////////////////////////////// Get order details //////////////////////////////////
echo '<h2>Szczegóły zamówienia</h2>';

$databaseManager = new DatabaseManager();
$query = "SELECT user_products.product_id, products.name, user_products.quantity, user_products.price, 
		  products.author,products.artist FROM `products`, `user_products` WHERE user_products.status LIKE 'koszyk'
		  AND user_products.user_id=".$_SESSION['u_id']." 
		  AND user_products.product_id=products.p_ID;";

if ($result = $databaseManager->getFromDatabase($query)){

	$_SESSION['finalPrice'] = null;  // Defining the final price
	while ($row = $result->fetch_assoc()) {
		echo "<br>".$row['name']."<br>";

		if ($row['author'] == null)
			echo $row['artist'];
		else
			echo $row['author'];

		echo "<br>Ilość: ".$row['quantity'];
		echo "<br>Koszt: ".str_replace(".", ",", $row['price'])." PLN";
		echo "<br>";
		$_SESSION['finalPrice'] = $_SESSION['finalPrice'] + $row['price'];
	}
	$result->free_result();
}

echo "<br>Łączny koszt: ".str_replace(".", ",", $_SESSION['finalPrice'])." PLN"; //Friendly price - with a comma

echo '<form method="post" action="../makeOrder.php">
		<br><input type="submit" value="Złóż zamówienie" name="submitOrder">
	  </form>';	

echo'<h4><a class="linkBack" href="./basket.php">Wstecz</a></h4>'
?>
</body>
</html>