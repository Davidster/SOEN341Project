<?php   

	//to ensure you are using same session
	session_start();

	//destroy the session
	$_SESSION = array();
	session_destroy();

	//to redirect back to "index.php" after logging out
	header("location: ../index/home.php"); 

?>