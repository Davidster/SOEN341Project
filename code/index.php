<?php
require_once 'sql_connect.php';
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
				<li pagetarget="about-page">About</li>
			</ul>
		</nav>
		<div id="page-content">
			<div id="home-page" style="display: block">
				Home page
			</div>
			<div id="register-page">
				<form id="createAccount" action="" method="post">
					<input type="text" name="username" />
					</br></br>
					<input type="password" name="password" />
					</br></br>
					<input type="radio" name="accountType" />
					Teacher's Assistant
					</br>
					<input type="radio" name="accountType" />
					Student
					</br></br>	
					<input type="submit" value = "Submit" />
				</form>
			</div>
			<div id="login-page">
				<form id="login" action="" method="post">
					Please enter your email:
					</br>
					<input type="text" name="username" />
					</br></br>
					Please enter your password:
					</br>
					<input type="password" name="password" />
					</br></br>
					<input type="submit" value = "Enter" />
				</form>	
			</div>
			<div id="contact-page">
				Contact page
			</div>
			<div id="about-page">
				About page
			</div>
		</div>
		<footer>
			<div class="legal">Copyright 2016 Mikel Shifrin.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2016</div>
		</footer>	
	</body>
</html>