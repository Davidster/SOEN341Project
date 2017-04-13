<?php
	require_once '../../sql_connect.php';
	require_once '../functions.php';

	//authentification
	if(isset($_POST['logbtn'])){

		$email = $_POST['email'];
		$password = $_POST['password'];

		loginUser($email, $password, $dbc, false);
	}


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Log in</title>
		<meta charset="UTF-8" />
		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../js/animsition/animsition.min.css">
		<link rel="stylesheet"  href="../../css/login.css" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
	<!--<div class="animsitionLogin" >-->

		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" >Moodle 2.0</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
						<li><a href="createAccount.php"><span class="glyphicon glyphicon-user"></span> Create Account</a></li>
						<li class = "active"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
						<li><a href="about.php"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>
					</ul>
				</div>
			</div>
		</nav>
        <div class="container">
            <div class='col-lg-8 col-lg-offset-2'>
				<div class='form-group'>
					<h1>Login Page</h1>
				</div>
				<form id = 'login' action= '' method = 'post'>
					<div class="form-group">
						<label><p>Enter your email:</p></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input class="form-control" type='email' name='email' placeholder='Email Address' required>
						</div>
					</div>
					<div class="form-group">
						<label><p>Enter your password:</p></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input class="form-control" type='password' name='password' placeholder='Password' required>
						</div>
					</div>
					<br/>
					<input type='submit' value='Enter' name='logbtn' class="btn btn-default"/>
				</form>
			</div>
        </div>
	</div>
	<footer style="background-color: #222222;padding: 25px 0;color: rgba(255, 255, 255, 0.3);text-align: center;postion:absolute;bottom:0;">
		<div class="container">
			<p style="font-size: 12px; margin: 0;">
				&copy; Winter 2017 SOEN341 Project. All Rights Reserved.<br/>
				Contact Us: 1-800-123-4567
			</p>
		<!--</div>-->
	</footer>
	<script src="../../js/jquery-1.11.2.min.js"></script>
	<script src="../../js/animsition/animsition.min.js"></script>
	<script src="../../js/sticky/jquery.sticky.js"></script>
	<script src="../../js/main.js"></script>
	</body>
</html>
