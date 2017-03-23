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
		<link rel="stylesheet" href="../../css/style.css" />

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
						<li><a href="chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
						<li><a href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="profile" align= "center">
	
			<?php 
					echo '<span style="front-size: 45px;front-family: Helvetica;color: #7B7A7A;">Welcome to your portal ' .$_SESSION['name']. '!</span></br>';
					echo '<span style="front-size: 25px;front-family: Helvetica;color: #7B7A7A;">email: '.$_SESSION['email']. '</span></br>';
				if($TA){
					
					 echo $_SESSION['class'];
					 echo $_SESSION['section']."</br>";
					 $ta= $_SESSION['ta'];
					 $result = mysqli_query($dbc,"SELECT * FROM Project WHERE ta='$ta'");

					 echo 'Student list:';
						 while( $row = mysqli_fetch_assoc($result)){
							echo $row['sid']."</br>";
							
						 }
					}
					
				
				else{
					$sid = $_SESSION['sid'];
					echo '<span style="front-size: 25px;front-family: Helvetica;color: #7B7A7A;">Student ID: '.$_SESSION['sid']. '</span></br></br></br>';	
					
					echo'My Projects ';
				
					
					
					for($i=1;$i<=$_SESSION['total'];$i++){
						$c = "class$i";
						$s = "section$i";

						echo "</br> <button class=\"button big alt\"> $_SESSION[$c]. $_SESSION[$s] </button>";
						
					}
				}			
			?>
		
</div>		

<!--

			<input value=?php $row['sid'] ?> type="hidden" name="search">
			
			<h1> SOEN341AA </h1>
			
			<a href="viewGroup.php">
			   <input type="button" value="200"class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="201" class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="202"class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="203"class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="204"class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="205"class="button" />
			</a>








-->

		
			<!--<div id="livechat-page" style="display: block;">
				/*
				
				php $chat->printChat(); ?>
				
				*/
			</div>-->
				
		
		<footer class="end">
			
			<div>Running into issues? Please contact us: 1800-123-4567.</div>

		</footer>
		   
	</body>
</html>