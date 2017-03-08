<?php
require_once 'sql_connect.php';
require_once dirname(__FILE__)."/phpfreechat-1.7/src/phpfreechat.class.php";
$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
$chat = new phpFreeChat($params);
//include ("loginForm.php");
//authentification
			if(isset($_POST['logbtn']))
			{
				$email = $_POST['email'];
				$password = $_POST['password'];

				$dbsearch = "SELECT * FROM Ta where temail = '$email'";
				$query = mysqli_query($dbc, $dbsearch); //pass this query to our db
				$found = mysqli_num_rows($query); //returns number of found rows

				//entry is found
				if($found == 1)
				{
					$row = mysqli_fetch_assoc($query);
					$dbname = $row['tname'];
					$dbpassword = $row['tpassword'];
					$dbusername = $row['temail'];
					//password is correct
					if($password == $dbpassword)
					{
						header('location: login.php');
					}
					else echo $wrongpassword = " <h3> Wrong password, please try again! </h3>";
				}
				else echo $nouserfound = "<h3> No such user found, please try again or register!</h3>";
			}

		
?>

<!DOCTYPE html>
<html>
	<head>
		<title>First Page</title>
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
				<li pagetarget="register-page">Create Account</li>
				<li pagetarget="login-page">Login</li>
				<li pagetarget="contact-page">Contact</li>
				<li pagetarget="course-page">Course Page</li>
				<li pagetarget="about-page">About</li>
				<li pagetarget="livechat-page">Chat Test</li>
			</ul>
		</nav>
		<div id="page-content">
			<?php
				include ('php/index/homepage.php');
				include ('php/index/registerPage.php');
				include ('php/index/loginForm.php');
				include ('php/index/contactPage.php');
				include ('php/index/coursePage.php');
				include ('php/index/aboutPage.php');
			?>
			 <?php 
			//gets user input
			if(isset($_POST['register']))
			{
				$id = $_POST['id'];
				$name = $_POST['fullName'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$repassword = $_POST['repassword'];
				/*
				Eventually here we will have to add a method to restrict registration permissions
				1- Only a valid Concordia student may register
				2- That student's classes must be registerd in the system
				3- Maybe ask for class id and tutorial group to segment automatically (if that makes any sense)
				*/

				//check if passwords are exact
				if($password == $repassword)
				{	
					$register = "INSERT INTO Student (sid, name, password, email) VALUES ('$id','$name','$password', '$email')";

				if(mysqli_query($dbc, $register))
				{
					$success = "<h2>Record created successfully!</h2>";
				}
				else{
					echo "<h2> Sorry. This Concordia ID is already registered in the system</h2>";
					}
				}
				else{
					$passdontmatch = "<h2> The passwords you entered do not match. Try again.</h2>";
				}

			}
			if (isset($success)) {echo $success;}
  			if (isset($passdontmatch)) {echo $passdontmatch;}

			?>
			<div id="livechat-page" style="display: block;">
				<?php $chat->printChat(); ?>
			</div>
			
		<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>		
	</body>
</html>
