<?php
	session_start();
	require_once '../../../sql_connect.php';
	if(isset($_SESSION['logon'])){
		if(!$_SESSION['logon']){ 
			header("Location: ../../index/home.php");
			die();
		}
	}
	else{
		header("Location: ../../index/home.php");
	}

	//check if TA user is logged in
	$TA= false;
	if(isset($_SESSION['ta'])){
		$GLOBALS['TA'] = true;
	}
?>
	<!DOCTYPE html>
<html>
	<head>
		<title>Log in</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../../css/index.css"/>

		<!-- Import JQuery library (REMOVE THIS COMMENT AT SOME POINT) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

		<link rel="shortcut icon" href="../../../pictures/favicon.ico" type="image/x-icon">
		
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
						<li><a href="../myProfile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
						<li class = "active"><a href="myClass.php"><span class="glyphicon glyphicon-education"></span> My Class</a></li>	
						<li><a href="../chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
						<li><a href="../logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div id="page-content">
		
			<?php 
				if($TA){
					echo $_SESSION['class'];
					echo $_SESSION['section']."</br>";
					$ta= $_SESSION['ta'];
					$query1 = mysqli_query($dbc,"SELECT * FROM Project WHERE ta='$ta'");
					echo $classSize = mysqli_num_rows($query1);
					echo "</br>";

					$query2 = mysqli_query($dbc,"SELECT 1 FROM Project WHERE ta= '$ta' AND pid='0'");
					if(mysqli_num_rows($query2)==0){
						while( $row = mysqli_fetch_assoc($query1)){
							echo $row['sid']."</br>";
							
						}
					}
					else{
						$query3= mysqli_query($dbc,"SELECT * FROM Project WHERE ta= '$ta' ORDER BY pid ASC");
						while( $row = mysqli_fetch_assoc($query1)){
							echo "Student: ". $row['sid']. " Team #: ". $row['pid']. "</br>";
							
						}
					}
				}
				else echo $_SESSION['sid'];
				
				
			?>

			<div>
				<form id='make' action= '' method='post'>
				<input type='text' name='teamsOf' placeholder= 'team size' required>
				<input type='submit' value='Create Teams' name='make'>
				</form>
			</div>

			<div>
				<form id='undo' action='' method ='post'>
				<input type='submit' value='Undo Teams' name='undo'>

			<?php

				$ta = $_SESSION['ta'];
				//find all students in TAs class
 				$query = mysqli_query($dbc, "SELECT * FROM Project WHERE ta = '$ta'");

				if(isset($_POST['make'])){
					$teamSize = $_POST['teamsOf'];
					$numOfTeams = ceil($classSize / $teamSize);
					//$extraStudents = ($classSize % $teamSize);
					//creates groups by joining the next number of students on the same team
					$count=0;
					$i=0;
					while($row = mysqli_fetch_assoc($query)){
						if(($count++ % $teamSize)==0){
							$i++;
						}
						$student = $row['sid'];
						mysqli_query($dbc, "UPDATE Project SET pid ='$i' WHERE sid = '$student' AND ta= '$ta'");
					
					}
					if($i== $numOfTeams){
						echo "<h2> Succesfully created $i teams";
					}
				}

				if(isset($_POST['undo'])){
					while($row = mysqli_fetch_assoc($query)){
						mysqli_query($dbc, "UPDATE Project SET pid ='0' WHERE ta= '$ta'");
					}
					echo "<h2>Deleted groups</h2>";
				}
			?>


			<!--<input value=<?php $row ?> type="hidden" name="search">
			
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
		</div>	
		<div>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>
		</div>	

	</body>
</html>