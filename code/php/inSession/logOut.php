<?php

	//to ensure you are using same session
	if(session_id() == '' || session_status() == PHP_SESSION_NONE) {
    	session_start();
	}

	function performLogout(){
			//destroy the session
		$_SESSION = array();
		session_destroy();

		//Ensure that the cookie is destructed by setting a date in the past
		setcookie(session_name(), false, time() - 3600);

		//to redirect back to "index.php" after logging out
		header("location: ../index/home.php");
	}

	performLogout();

?>
