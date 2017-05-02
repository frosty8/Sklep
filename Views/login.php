<?php
require_once '../Controllers/DatabaseManager.php';
require_once '../Controllers/ViewController.php';

////////////////////////////////// Navigation Bar //////////////////////////////////
$viewController = new ViewController();
echo $viewController->getPageHead("Logowanie");
echo $viewController->getNavBar();
////////////////////////////////// Already logged in - redirect //////////////////////////////////
session_start();
if (isset($_SESSION['login'])) {
	header('Location: index.php');
	exit();
}
////////////////////////////////// User logging - chceck the user (logging form) /////////////////////////////
if (isset($_POST['login'])) {

	$databaseManager = new DatabaseManager();
	$query = "SELECT name, privileges, U_ID, adress FROM users WHERE name 
		LIKE '". mysql_real_escape_string($_POST['login']) ."' 
		AND password LIKE '". mysql_real_escape_string($_POST['password']) ."'";

	if ($result = $databaseManager->getFromDatabase($query)){
//////////////////////////////////////////// User logging - user found ////////////////////////////////////
		if ($result->num_rows>0) {
			$row = $result->fetch_assoc();
////////////////////////////////// Session variables for logged user //////////////////////////////////
			$_SESSION['logged'] = true;
			$_SESSION['login'] = $row['name'];
			$_SESSION['privileges'] = $row['privileges'];
			$_SESSION['u_id'] = $row['U_ID'];
			$_SESSION['u_adress'] = $row['adress'];
			$_SESSION['sessionStart'] = time(); //Stores a simple time of logging/refreshing/redirecting etc.

///	/	/	/	/	S	E	S	S	I	O	N		T	I	M	E	/	/	/	/	/	/	/	/	/	/	////
			$_SESSION['sessionTime'] = 15*60;
			
			header('Location: index.php');	 	
		}
		else
			echo '<span style="color:red;">Błędny login lub hasło</span><br>';
	}
	$result->free_result();
}
	unset($_POST['login']);
	unset($_POST['password']);

//HINTS
//echo "Konto admin:<br> Login: admin, hasło: admin<br>";
//echo "Konto user:<br> Login: user, hasło: user<br>";

///////////////////////////////////////////////// Logging form ////////////////////////////////////////////////
echo $viewController->getLoggingForm();

?>

</body>
</html>
