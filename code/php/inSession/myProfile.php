<?php
	session_start();
	require_once '../../sql_connect.php';
	if(isset($_SESSION['logon'])){
		if(!$_SESSION['logon']){ 
			header("Location: ../index/home.php");
			die();
		}
	}
	else{
		header("Location: ../index/home.php");
	}
	require_once '../../sql_connect.php';
	//require_once dirname(__FILE__)."../../phpfreechat-1.7/src/phpfreechat.class.php";
	//$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
	//$params["nick"] = $_SESSION['name'];
	//$chat = new phpFreeChat($params);

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

		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="myProfile.php">Moodle 2.0</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li class = "active"><a href="myProfile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
						<?php
							if($TA)
								echo '<li><a href="ta/myClass.php"><span class="glyphicon glyphicon-education"></span> My Class</a></li>';
							else
								echo '<li><a href="student/myProjects.php"><span class="glyphicon glyphicon-folder-open"></span> My Projects</a></li>';
						?>	
						<li><a href="chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
						<li><a href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div id="page-content">
			<?php 



				echo $_SESSION['name']. "</br>";
				echo $_SESSION['email']. "</br>";
				if($TA){
					echo $_SESSION['ta'];
					echo "</br>".$_SESSION['class']."</t>".$_SESSION['section'];
				}
				else{
					$sid = $_SESSION['sid'];
					echo $sid;	
					
					for($i=1;$i<=$_SESSION['total'];$i++){
						$c = "class$i";
						$s = "section$i";
						echo "</br>$_SESSION[$c]";
						echo "</br>$_SESSION[$s]";
					}
				}			
			?>
			<div id="home-page">
				<h2>Welcome to your portal!</h2>
				<button class="btn">Change passeword</button>
				</br></br>
				<button class="btn">Personal information</buttom>
			</div>
			    
			<!--<div id="livechat-page" style="display: block;">
				<?php $chat->printChat(); ?>
			</div>-->
				
		</div>
		<!--<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>-->
	</body>
</html>