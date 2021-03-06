<?php
	if(session_id() == '' || session_status() == PHP_SESSION_NONE) {
    	session_start();
	}
	require_once '../../sql_connect.php';
	if(!isset($_SESSION['logon'])){
		//destroy the session
		$_SESSION = array();
		session_destroy();

		//Ensure that the cookie is destructed by setting a date in the past
		setcookie(session_name(), false, time() - 3600);

		header("Location: ../index/home.php");
		}

	//check if TA user is logged in
	$TA = false;
	if(isset($_SESSION['ta'])){
		$GLOBALS['TA'] = true;
	}
	$classes = array();
	if($TA){
		$ta = $_SESSION['ta'];
		$queryGroup = mysqli_query($dbc, "SELECT DISTINCT pid FROM Project WHERE ta = '$ta'");
		$row= mysqli_fetch_assoc($queryGroup);
		$numberOfGroups = mysqli_num_rows($queryGroup);
		if($row['pid'] != 0){
			for($i = 1; $i <= $numberOfGroups;$i++){
				$classes[] = $_SESSION['class'] . " " . $_SESSION['section'] . "-" . $i;
			}
		}
		else{
			$classes[] = $_SESSION['class'] . " " . $_SESSION['section'] . "-" . 0;
		}
	}
	else{
		for($i = 1; $i <= $_SESSION['total']; $i++){
			$c = "class$i";
			$s = "section$i";
			$p = "project$i";
			$classes[] = $_SESSION[$c] . " "  . $_SESSION[$s] . "-" . $_SESSION[$p];
		}
	}

	require_once '../../phpfreechat-1.7/src/phpfreechat.class.php';
	$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
	$params["title"] = "My Chat";
	$params["nick"] = $_SESSION['name']; // user's nickname for chat
	$param["frozen_nick"] = $_SESSION['name']; // doesn't allow nickname to be changed
	$params["data_public_url"]   = "../../phpfreechat-1.7/data/public";
	$params["server_script_url"] = "./chat.php";
	$params["theme_default_url"] = "../../phpfreechat-1.7/themes";
	$params["channels"] = $classes; // chat channels open to user
	$params["frozen_channels"] = $classes; // chat channels user can have access to
	$chat = new phpFreeChat($params);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Personal page</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../css/index.css"/>
		<link rel="stylesheet" type="text/css" href="../../css/chat.css"/>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script type="text/javascript">
			var $j = jQuery.noConflict();

			$j(document).ready(function(){
			    $j("a[href='logOut.php']").click(function(e){
			  		//call the internal disconnect function of phpfreechat
					pfc.connect_disconnect();
			    });
			});
		</script>

		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../js/animsition/animsition.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="animsition">
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand">Moodle 2.0</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="myProfile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
						<li class="active"><a href="chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
						<li><a href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div id="page-content">
			<?php
				$chat->printChat();
			?>
		</div>
</div>

	<script src="../../js/jquery-1.11.2.min.js"></script>
	<script src="../../js/animsition/animsition.min.js"></script>
	<script src="../../js/sticky/jquery.sticky.js"></script>
	<script type="text/javascript" src="../../js/main.js"></script>

	</body>
</html>
