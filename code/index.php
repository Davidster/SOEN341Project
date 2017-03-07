<?php
require_once 'sql_connect.php';
require_once dirname(__FILE__)."/phpfreechat-1.7/src/phpfreechat.class.php";
$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
$chat = new phpFreeChat($params);
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
			<div id="home-page" style="display: none">
				Home page
			</div>
			 <?php 
			
			 $form = "<div id='register-page' style='display: none'>
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
			</div>";
			echo $form;

  			
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

			;?>
		

			<?php
			$form2 = "
			<div id='login-page' style='display: none'>
				<h1>Login Page</h1>
				<form id='login' action='' method='post'>
					<p>Enter your email:</p>
					<input type='email' name='email' placeholder='Email Address' required/>
					</br>
					<p>Enter your password:</p>
					<input type='password' name='password' placeholder='Password' required/>
					<input type='submit' value='Enter' name='logbtn'/>
				</form>	
			</div>";

			echo $form2;

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
						echo $welcome = "<h3>Login succesful, welcome  $dbname!";
					}
					else echo $wrongpassword = " <h3> Wrong password, please try again! </h3>";
				}
				else echo $nouserfound = "<h3> No such user found, please try again or register!</h3>";
			}

			;?>

			<div id="contact-page" style="display: none">
				Contact page
			</div>
			
			
			<div id="course-page" style="display: none;">
			
			
			
				<h2>Courses Page</h2>
				<p>Select the class corresponding to your group project. You will be redirected to the course page.</p>

				<div class="dropdown" >
				  <button class="btn">Courses</button>
				  <div class="content" style="left:0;">
						<a href="#">SOEN 341</a>
						<a href="#">SOEN 490</a>
						<a href="#">SOEN 287</a>
						<a href="#">COEN 390</a>
				  </div>
				</div>			
			</div>
			
			<div id="about-page" style="display: none;">
                <div class="ourVision">
					<h1 class = "opening">Our Vision</h1>
					<p>
					Our mission is to provide a simple and useful web platform for group projects. This interface can be use for both, students and teacher's assistants, 
					and supplies a good way to interact within the team and with the teacher assistant. 
					</p>
	           </div>
                <div class="aboutUs">
					<h1 class="opening">About Us</h1>
					<p>
					We are a team of students in Software engineering and Computer engineering. Inspired by the idea of having a site dedicated to group projects, 
					we decided to built a webstite that would contains all the features needed to work on the given project. 
					</p>
					<br><br><br><br>
				</div>
                <div class="about">
                To know more about our project, please visit our <a href = "https://github.com/Davidster/SOEN341Project.git"> GitHub repository </a>.
                </div>
                
			</div>
			<div id="livechat-page" style="display: block;">
				<?php $chat->printChat(); ?>
			</div>
		</div>
		<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>		
	</body>
</html>
