<?php
require_once '../Controllers/ViewController.php';
require_once '../Controllers/SessionController.php';

////////////////////////////////// Session - redirect //////////////////////////////////
session_start();
if (!isset($_SESSION['login'])) {
	header('Location: index.php');
	exit();
}
////////////////////////////////// Session timer //////////////////////////////////
else{
	$sessionController = new SessionController();
	$sessionController->checkSessionTime($_SESSION['sessionStart']);
}
////////////////////////////////// Navigation Bar //////////////////////////////////
$viewController = new ViewController();
echo $viewController->getPageHead("Dziękujemy za zamówienie");
echo $viewController->getNavBar();

echo '<br><h1 style="text-align: center;"><a href="index.php" class="mainLink">DZIĘKUJEMY ZA ZAMÓWIENIE</a></h1>';

?>
</body>
</html>