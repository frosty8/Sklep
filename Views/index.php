<?php
require_once '../Controllers/SessionController.php';
require_once '../Controllers/ViewController.php';

////////////////////////////////// Session timer //////////////////////////////////
session_start();
if(isset($_SESSION['login'])){
	$sessionController = new SessionController();
	$sessionController->checkSessionTime($_SESSION['sessionStart']); //Start stores the time of logging/refreshing etc
}
////////////////////////////////// Navigation Bar //////////////////////////////////
echo '<h1 style="text-align:center;">Project XII</h1>';
$viewController = new ViewController();
echo $viewController->getPageHead("Project XII - Strona główna");
echo $viewController->getNavBar();
////////////////////////////////// For logged users //////////////////////////////////
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {

	echo $viewController->getSideBar(true);
}
////////////////////////////////// For other users //////////////////////////////////
else{
	echo $viewController->getSideBar(false);
}
?>
</body>
</html>


