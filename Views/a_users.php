<?php
require_once '../Controllers/SessionController.php';
require_once '../Controllers/DatabaseManager.php';
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
echo $viewController->getPageHead("Użytkownicy");
echo $viewController->getNavBar();
////////////////////////////// (ADMIN) Check the list of registered users ///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<h2>Użytkownicy</h2><br>";

$databaseManager = new DatabaseManager();
$query = "SELECT users.name,users.adress,users.privileges,users.rgst_date FROM users";

if($result = $databaseManager->getFromDatabase($query)){

	while($row = $result->fetch_assoc()){
		echo $row['name'];
		if ($row['privileges']<1) {echo "<br>Adress: ".$row['adress'];}
		if ($row['privileges']>0) {echo "<br>(ADMIN) Privileges lvl: ".$row['privileges'];}
		echo "<br>Rejestracja: ".$row['rgst_date'];
		echo "<br><br>";  
	}
}
echo '<h4><a href="./myProfile.php" class="linkBack">Powrót</a></h4>';
?>
</body>
</html>