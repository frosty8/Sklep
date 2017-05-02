<?php
require_once 'Controllers/DatabaseManager.php';
session_start();

if (isset($_SESSION['login']) && isset($_GET['pID'])) {

	$databaseManager = new DatabaseManager();
	$query = "DELETE FROM `user_products` WHERE `basket_product_id`=".$_GET['pID'];

	if ($result = $databaseManager->getFromDatabase($query))
		header('Location:/Sklep/Views/basket.php');
}





?>