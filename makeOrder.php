<?php
require_once 'Controllers/DatabaseManager.php';
require_once 'Controllers/SessionController.php';

////////////////////////////////// Session timer //////////////////////////////////
session_start();
if(isset($_SESSION['login'])){
	$sessionController = new SessionController();
	$sessionController->checkSessionTime($_SESSION['sessionStart']);
}
////////////////////////////////// Session - redirect //////////////////////////////////
if (!isset($_POST['submitOrder'])) {
	header('Location: index.php');
	exit();
}
////////////////////////////////// Register a new order //////////////////////////////////
else {
	$userID = $_SESSION['u_id'];
	$price = $_SESSION['finalPrice'];

	$databaseManager = new DatabaseManager();
	$multiQuery = "INSERT INTO `orders` (`O_ID`, `u_ID`, `final_price`, `ord_date`, `status`) VALUES 
			  (NULL, '".$userID."', '".$price."', now(), 'przyjęto');
			  UPDATE user_products SET status = 'przyjęto' WHERE user_id = ".$userID;

	if ($result = $databaseManager->getManyFromDatabase($multiQuery))
		header('Location: Views/thankYou.php');

	unset($_POST['submit']);
	unset($_SESSION['final_price']);
}


?>