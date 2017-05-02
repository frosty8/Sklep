<?php
require_once '../Controllers/DatabaseManager.php';
require_once '../Controllers/ViewController.php';
require_once '../User.php';
require_once '../Admin.php';

////////////////////////////////// Navigation Bar //////////////////////////////////
$viewController = new ViewController();
echo $viewController->getPageHead("Zarejestruj się");
echo $viewController->getNavBar();
/////////////////////////////////////// Register a new user ///////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
// Form has been submited - quick validation
	if (isset($_POST['newLogin'])) {

		$databaseManager = new DatabaseManager();
		$flagOK = true;
		$nLogin = mysql_real_escape_string($_POST['newLogin']);
		$nPassword = mysql_real_escape_string($_POST['newPassword']);
		$nAdress = mysql_real_escape_string($_POST['newAdress']);

	if ($nLogin == null || $nPassword == null || $nAdress == null) {
		echo '<span style="color:red;">Proszę podać prawidłowe dane</span>';
		$flagOK = false;
	}
		
	if (!isset($_POST['newRules']))
		$flagOK = false;

	$query = "SELECT name FROM `users` WHERE name LIKE '". $nLogin ."'";
	$result = $databaseManager->getFromDatabase($query);

	if(!$result || $result->num_rows>0){
		echo '<span style="color:red;">Ta nazwa jest już w użyciu. Ha, ha...</span><br>';
		$flagOK = false;
	}
///////////////////////////////////// Registering a new user ///////////////////////////////////////////////
	if($flagOK){

		$newUser = new User($nLogin, $nPassword, $nAdress);
		$query = $newUser->buildQuery();

		if ($result = $databaseManager->getFromDatabase($query))
			echo '<span style="color:#00DD00;"><b>Dziękujemy za rejestrację!</b></span>';
	}
	else{
			echo '<span style="color:red;"><b>Wprowadź prawidłowe dane</b></span>';
	}
	unset($_POST['newLogin']);
}
///////////////////////////////// Registering a new user - form  ///////////////////////////////////////////
echo $viewController->getRegisterForm();

?>
</body>
</html>