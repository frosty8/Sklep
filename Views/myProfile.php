<?php
require_once '../Controllers/ProductManager.php';
require_once '../Controllers/DatabaseManager.php';
require_once '../Controllers/SessionController.php';
require_once '../Controllers/ViewController.php';
require('fpdf.php');

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
echo $viewController->getPageHead("Moje konto");
echo $viewController->getNavBar();
////////////////////////////////// (ADMIN) Add a new product, execute form //////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['productName'])) {
	$manager = new ProductManager();

	$_POST['productName'] = mysql_real_escape_string(htmlentities($_POST['productName'], ENT_QUOTES, "UTF-8"));
	$_POST['productAuthor'] = mysql_real_escape_string(htmlentities($_POST['productAuthor'], ENT_QUOTES, "UTF-8"));
	$_POST['productDescription'] = mysql_real_escape_string(htmlentities($_POST['productDescription'], ENT_QUOTES, "UTF-8"));

	if ($_POST['productName'] == null || $_POST['productAuthor'] == null || 
		$_POST['productPrice'] == null || $_POST['productDescription'] == null){
		echo "Proszę podać prawidłowe dane";

		echo $viewController->getAdminForm();
		echo $viewController->getFooterLinks();
		exit();
	}

	//Database always stores price with a dot: '.' however price in form can be put either with a ',' or a '.'
	$friendlyPrice = str_replace(",", ".", $_POST['productPrice']); 
	$prodType = $_POST['productType'];

	//Creating product object
	$newProduct = $manager->createProduct($prodType, $_POST['productName'], $friendlyPrice, $_POST['productAuthor'], $_POST['productDescription']);

	$manager->addProductToDb($newProduct);
}	
////////////////////////////////// (ADMIN) Add a new product - form //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
if($_SESSION['privileges']>0){
	echo "<h4>Panel administracyjny</h4>";
	echo "Dodaj produkty<br>";

	echo $viewController->getAdminForm();
////////////////////////////// (ADMIN) Lists of registered users and orders //////////////////////////////
	echo '<h4><a href="a_users.php" class="regularLink">Użytkownicy</a></h4>';
	echo '<h4><a href="a_orders.php" class="regularLink">Zamówienia</a></h4>';
}
else{
////////////////////////////// (USER) My orders //////////////////////////////
	$databaseManager = new DatabaseManager();
	$query = "SELECT orders.u_id, orders.O_ID, orders.final_price, orders.ord_date, orders.status
		FROM `orders`
		WHERE orders.u_id = ".$_SESSION['u_id'];

	if ($result = $databaseManager->getFromDatabase($query))
////////////////////////////////// User's orders /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<h1>Twoje zamówienia</h1>";

	if ($result->num_rows < 1) 
		echo "<h2>Nie masz zamówień</h2>";

	while ($row = $result->fetch_assoc()) {
		echo "Numer zamówienia: <b>".$row['O_ID']."</b><br>";
		echo "Koszt: ".str_replace(".", ",", $row['final_price'])." PLN<br>";
		echo "Status: ".$row['status']." - ".$row['ord_date']."<br>";
		echo '<a class="regularLink" target="blank" href="details.php?order='.$row['O_ID'].'">
				Wydruk
			  </a><br><br>';
	}
}

echo $viewController->getFooterLinks();
?>
</body>
</html>
