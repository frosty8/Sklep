<?php
require_once '../Album.php';
require_once '../Book.php';
require_once '../Controllers/ProductManager.php';
require_once '../Controllers/SessionController.php';
require_once '../Controllers/DatabaseManager.php';
require_once '../Controllers/ViewController.php';

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
echo $viewController->getPageHead("Koszyk");
echo $viewController->getNavBar();
////////////////////////////////// Adding to the basket ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
$databaseManager = new DatabaseManager();

if (isset($_GET['p_ID']) && isset($_POST['quantity']) && $_POST['quantity'] > 0) {
//1. Select the product to throw into the basket - clicked "Do koszyka" (productView)

	$_SESSION['p_ID'] = $_GET['p_ID'];

	$query = "SELECT `p_ID`, `name`, `author`, `artist`, `price` FROM `products` WHERE `p_ID` 
	LIKE '".$_GET['p_ID']."'";

	if ($result = $databaseManager->getFromDatabase($query)){
/////////////////////////////////// 2. Fetch product details /////////////////////////////////

		$row = $result->fetch_assoc();

		$p_name = $row['name'];
		$p_author = $row['author'];
		$p_artist = $row['artist'];
		$p_price = $row['price'];						

		if (is_null($row['author']))
			$_SESSION['maker'] = $row['artist'];		// Only 2 possibilities
		else
			$_SESSION['maker'] = $row['author'];

		$result->free_result();
////////////////////////////////// 3. Add a product to the database basket //////////////////////////////////

		$_SESSION['price'] = number_format($p_price*$_POST['quantity'],2);

		$addQuery = "INSERT INTO 
		`user_products`(basket_product_id, user_id, product_id, quantity, price, status) 
		VALUES (NULL, '".$_SESSION['u_id']."', '".$_SESSION['p_ID']."', '".$_POST['quantity']."',
		'".$_SESSION['price']."', 'koszyk')";

		if ($result = $databaseManager->getFromDatabase($addQuery))
			echo '<span style="color:#00DD00;"><b>Dodano do koszyka</b></span>';
	}
}
		unset($_POST['quantity']);

///////////////////////////////// Show content of the basket ///////////////////////////////////////

echo "<h2>Twój koszyk</h2>";
$query = "SELECT user_products.basket_product_id, user_products.product_id, products.name, user_products.quantity, 			  user_products.price, products.author,products.artist FROM 
		  `products`, `user_products` WHERE user_products.status LIKE 'koszyk'
		  AND user_products.user_id=".$_SESSION['u_id']."
		  AND user_products.product_id=products.p_ID;";


if ($result = $databaseManager->getFromDatabase($query)){

	while ($row = $result->fetch_assoc()) {
		echo "<br>".$row['name']."<br>";

		if ($row['author'] == null)
			echo $row['artist'];
		else
			echo $row['author'];

		echo "<br>Ilość: ".$row['quantity'];
		echo "<br>Koszt: ".str_replace(".", ",", $row['price'])." PLN";
		echo "<br><br>";
		echo '<form method="post" action="../remove.php?pID='.$row['basket_product_id'].'">
				<input type="submit" value="Usuń" >
			  </form>';
	}
///////////////////////////////////// Make an order /////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
	if ($result->num_rows < 1)
		echo "<h4>Twój koszyk jest pusty</h4>";
	else
		echo '<form method="post" action="order.php">
	  			<br><br><input type="submit" value="Przejdź do zamówienia" >
		  	</form>';

$result->free_result();
}
?>
<h3><a class="linkBack" href="./produkty.php">Produkty</a></h3>
</body>
</html>
