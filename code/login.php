<?php
session_start();
require_once 'sql_connect.php';
require_once dirname(__FILE__)."/phpfreechat-1.7/src/phpfreechat.class.php";
$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
$chat = new phpFreeChat($params);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>personal page</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/index.css"/>

		<!-- Import JQuery library (REMOVE THIS COMMENT AT SOME POINT) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


		<script type="text/javascript" src="js/main.js"></script>
		<link rel="shortcut icon" href="pictures/favicon.ico" type="image/x-icon">
	</head>
	<body>
		<nav>
			<ul class="menu" id="menu">
				<li pagetarget="home-page">Home</li>
				<li><a href = "logout.php">Logout</a></li>
				<li pagetarget="contact-page">Contact</li>
				<li pagetarget="course-page">Course Page</li>
				<li pagetarget="livechat-page">Chat Test</li>
			</ul>
		</nav>
		<div id="page-content">
			<?php 
				echo $_SESSION['name']. "</br>";
				echo $_SESSION['username'];
				include ('php/index/homepage.php');
				include ('php/index/contactPage.php');
				include ('php/index/coursePage.php');
			?>
		</div>
		<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>
	</body>
</html>