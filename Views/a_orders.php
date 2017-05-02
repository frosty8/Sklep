<?php
require_once '../Controllers/DatabaseManager.php';
require_once '../Controllers/SessionController.php';
require_once '../Controllers/ViewController.php';

////////////////////////////////// Session timer //////////////////////////////////
session_start();
if (!isset($_SESSION['login']) || $_SESSION['privileges'] < 1) {
	header('Location: ./index.php');
	exit();	
}
else{
	$sessionController = new SessionController();
	$sessionController->checkSessionTime($_SESSION['sessionStart']);
}
////////////////////////////////// Navigation Bar //////////////////////////////////

$viewController = new ViewController();
echo $viewController->getPageHead("Zamówienia");
echo $viewController->getNavBar();

////////////////////////////// (ADMIN) Check the list of registered orders //////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<h1>Zamówienia</h1>";

$databaseManager = new DatabaseManager();
$query = "SELECT orders.O_ID,orders.ord_date,orders.final_price,users.adress,users.name,orders.status
		  FROM orders, users WHERE orders.status NOT LIKE 'zrealizowano' AND orders.u_id=users.U_ID;";

if ($result = $databaseManager->getFromDatabase($query)){
	while ($row = $result->fetch_assoc()) {
		$ord_id = $row['O_ID'];
		$user = $row['name'];
		$final_price = str_replace(".", ",", $row['final_price']);
		$ord_date = $row['ord_date'];
		$ord_status = $row['status'];

		echo "Numer zamówienia: ".$ord_id;		
		echo "<br>Użytkownik: ".$user;		
		echo "<br>Cena: ".$final_price;		
		echo "<br>Data przyjęcia zamówienia: ".$ord_date;
		echo "<br>Status: ".$ord_status."<br><br>";
///////////////////////////////////// !Doesn't fetch product specification data! ////////////////////////////////
//Product specification info, quantity etc. are obligatory if orders are to be handled by the shop!  
	}
}
$result->free_result();

echo '<h4><a href="./myProfile.php" class="linkBack">Powrót</a></h4>';
?>
</body>
</html>