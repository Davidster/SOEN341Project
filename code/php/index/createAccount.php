<?php 
	require_once '../../sql_connect.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Create Account</title>
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
				<div id='register-page'>
					<h1>Register Page</h1>
					<form id='createAccount' action='' method='post'>
						<p>Enter your Concordia ID:</p>
						<input type='text' name='id' placeholder='Concordia ID' required/>
						<p>Enter your full name:</p>
						<input type='text' name='fullName' placeholder='Full Name' required/>
						<p>Enter your email:</p>
						<input type='email' name='email' placeholder='Email Address' required/>
						<p>Create a Password:</p>
						<input type='password' name='password' placeholder='Password' required/>
						<p>Confirm Password:</p>
						<input type='password' name='repassword' placeholder='Password' required/>
						<input type='radio' name='accountType' />
						Teacher's Assistant
						</br>
						<input type='radio' name='accountType' />
						Student
						</br></br>	
						<input type='submit' value = 'Submit' name='register'/>
					</form>
				</div>
			  <?php 
				//gets user input
				if(isset($_POST['register'])){
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
					if($password == $repassword){	
						//check if id is enrolled in class table
						$checkclass = "SELECT * from SOEN341 where sid = '$id'";
						$query = mysqli_query($dbc, $checkclass); //pass this query to our db
						$enrolled = mysqli_num_rows($query); //returns number of found rows

					//checks if entry is found in class TABLE
						if($enrolled == 1){
						$register = "INSERT INTO Student (sid, name, password, email) VALUES ('$id','$name','$password', '$email')";

							if(mysqli_query($dbc, $register)){
								$success = "<h2>Record created successfully!</h2>";
							}
							else{
							echo "<h2> Sorry. This Concordia ID is already registered in the system</h2>";
							}
						}
						else echo "<h2> Sorry, you are not enrolled for this class! </h2>";
					}
					else{
						$passdontmatch = "<h2> The passwords you entered do not match. Try again.</h2>";
					}

				}
				if (isset($success)) {echo $success;}
				if (isset($passdontmatch)) {echo $passdontmatch;}
			?>
		</div>	
		<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>		
	</body>
</html>
