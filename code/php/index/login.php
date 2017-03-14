<?php
	session_start();
	require_once '../../sql_connect.php';

	//authentification
	if(isset($_POST['logbtn'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$dbsearch = "SELECT * FROM Ta where temail = '$email'";
		$query = mysqli_query($dbc, $dbsearch); //pass this query to our db
		$found = mysqli_num_rows($query); //returns number of found rows

		//checks if entry is found in TA TABLE
		if($found == 1){
			$row = mysqli_fetch_assoc($query);
			$dbname = $row['tname'];
			$dbpassword = $row['tpassword'];
			$dbusername = $row['temail'];
			$dbtid = $row['tid'];
			//password is correct
			if($password == $dbpassword){
				$_SESSION['name'] = $dbname;
				$_SESSION['username'] = $dbusername;
				$_SESSION['tid'] = $dbtid;
				header('location: ../inSession/myProfile.php');
			}
			else echo $wrongpassword = " <h3> Wrong password, please try again! </h3>";
		}

		//checks if entry is found in Student table
		elseif($found == 0){
			$dbsearch = "SELECT * FROM Student where email = '$email'";
			$query = mysqli_query($dbc, $dbsearch); //pass this query to our db
			$found = mysqli_num_rows($query); //returns number of found rows
			
			if($found == 1){
				$row = mysqli_fetch_assoc($query);
				$dbname = $row['name'];
				$dbpassword = $row['password'];
				$dbusername = $row['email'];
				$dbsid = $row['sid'];
				//password is correct
				if($password == $dbpassword){
					$_SESSION['name'] = $dbname;
					$_SESSION['username'] = $dbusername;
					$_SESSION['sid'] = $dbsid;
					header('location: ../inSession/myProfile.php');
				}
				else echo $wrongpassword = " <h3> Wrong password, please try again! </h3>";
			}
		}

		//entry not found in Student and TA tables
		else echo $nouserfound = "<h3> No such user found, please try again or register!</h3>";
	}

		
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Log in</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../css/index.css"/>

		<!-- Import JQuery library (REMOVE THIS COMMENT AT SOME POINT) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">
	</head>

	<body>
		<nav>
			<ul class="menu" id="menu">
				<li><a href="home.php">Home</a></li>
				<li><a href="createAccount.php">Create Account</a></li>
				<li><a href="logIn.php">Log In</a></li>
				<li><a href="about.php">About</a></li>
			</ul>
		</nav>
		<div id="page-content">
			<div id='login-page'>
				<h1>Login Page</h1>
				<form id='login' action='' method='post'>
					<p>Enter your email:</p>
					<input type='email' name='email' placeholder='Email Address' required/>
					</br>
					<p>Enter your password:</p>
					<input type='password' name='password' placeholder='Password' required/>
					<input type='submit' value='Enter' name='logbtn'/>
				</form>	
			</div>
		</div>	
		<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>		
	</body>
</html>



