<?php
	session_start();
	if(!$_SESSION['logon']){ 
		header("Location: ../index/home.php");
		die();
	}
	require_once '../../sql_connect.php';
	require_once '../../phpfreechat-1.7/src/phpfreechat.class.php';
	//require_once dirname(__FILE__)."/phpfreechat-1.7/src/phpfreechat.class.php";
	$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
	$params["nick"] = $_SESSION['name'];
	$chat = new phpFreeChat($params);

	//check if TA user is logged in
	$TA= false;
	if(isset($_SESSION['ta'])){
		$GLOBALS['TA'] = true;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>personal page</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../css/index.css"/>

		<!-- Import JQuery library (REMOVE THIS COMMENT AT SOME POINT) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


		<script type="text/javascript" src="js/main.js"></script>
		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">
	</head>
	<body>
		<nav>
			<ul class="menu" id="menu">
				<li><a href="myProfile.php">My Profile</a></li>
				<?php
					if($TA)
						echo '<li><a href="ta/myClass.php">My Class</a></li>';
					else
						echo '<li><a href="student/myProjects.php">My Projects</a></li>';
				?>
				<li><a href="chat.php">Chat</a><li>
				<li><a href = "logOut.php">Log Out</a></li>
			</ul>
		</nav>
		<div id="page-content">
			<?php 
				echo $_SESSION['name']. "</br>";
				echo $_SESSION['email']. "</br>";
				if($TA) echo $_SESSION['ta'];
				else echo $_SESSION['sid'];

				$chat->printChat();
			?>		
		</div>
		<!--<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>-->
	</body>
</html>