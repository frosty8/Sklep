<?php

class SessionController
{
////////////////////////////////// Checking the expiration of the session //////////////////////////////////
	// current time - the time of the logging/request etc.

	public function checkSessionTime($sessionStart){

		////// Session expired ////
		if ((time() - $_SESSION['sessionStart']) > $_SESSION['sessionTime']) {
			session_unset();
			session_destroy();
			header('Location: ../Views/index.php');
			return false;
		}
		////// Session not expired yet - new current time ////
		else{
			$_SESSION['sessionStart'] = time();
			return true;
		}
	}
}



?>