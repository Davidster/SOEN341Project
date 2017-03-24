<?php
	session_start();
	$_SESSION['logon'] = false;
	require_once '../../sql_connect.php';

	//authentification
	if(isset($_POST['logbtn'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$emailSearchQuery = "SELECT * FROM Ta where email = '$email'";
		$emailQueryRes = mysqli_query($dbc, $emailSearchQuery); //pass this query to our db
		$emailMatchCount = mysqli_num_rows($emailQueryRes); //returns number of found rows

		//checks if entry is found in TA TABLE
		if($emailMatchCount == 1){
			$row = mysqli_fetch_assoc($emailQueryRes);
			$dbName = $row['name'];
 			$dbPassword = $row['password'];
 			$dbEmail = $row['email'];
 			$dbTID = $row['ta'];
 			$dbClass = $row['class'];
 			$dbSection = $row['section'];
			//password is correct
			if($password == $dbPassword){
				$_SESSION['name'] = $dbName;
				$_SESSION['email'] = $dbEmail;
 				$_SESSION['ta'] = $dbTID;
 				$_SESSION['class'] = $dbClass;
 				$_SESSION['section'] = $dbSection;
				$_SESSION['logon'] = true;

				header('location: ../inSession/myProfile.php');
			}
			else echo $passwordMismatch = " <h3> Wrong password, please try again! </h3>";
		}

		//checks if entry is found in Student table
		elseif($emailMatchCount == 0){
			$emailSearchQuery = "SELECT * FROM Student where email = '$email'";
			$emailQueryRes = mysqli_query($dbc, $emailSearchQuery); //pass this query to our db
			$emailMatchCount = mysqli_num_rows($emailQueryRes); //returns number of found rows
			
			if($emailMatchCount == 1){
				$row = mysqli_fetch_assoc($emailQueryRes);
				$dbName = $row['name'];
				$dbPassword = $row['password'];
				$dbEmail = $row['email'];
				$dbsid = $row['sid'];
				//password is correct
				if($password == $dbPassword){
					$_SESSION['name'] = $dbName;
					$_SESSION['email'] = $dbEmail;
					$_SESSION['sid'] = $dbsid;
					$_SESSION['logon'] = true;

					$projQueryRes = mysqli_query($dbc, " SELECT * FROM Project WHERE sid = '$dbsid'");
					$totalClasses = mysqli_num_rows($projQueryRes);	//returns number of projects
					$_SESSION['total'] = $totalClasses;

					//store each class, section and matching pid
					for($i = 1; $i <= $totalClasses; $i++){
						$row = mysqli_fetch_assoc($projQueryRes);

						$p = "project$i";
						$_SESSION[$p] = $row['pid'];	
						$ta = $row['ta'];

						$classQueryRes = mysqli_query($dbc, "SELECT * FROM ClassList WHERE ta= '$ta'");
						$row2 = mysqli_fetch_assoc($classQueryRes);
						$c = "class$i";
						$s = "section$i";

						$_SESSION[$c] = $row2['class'];
						$_SESSION[$s] = $row2['section'];
					}

					header('location: ../inSession/myProfile.php');
				}
				else echo $passwordMismatch = " <h3> Wrong password, please try again! </h3>";
			}
		}

		//entry not found in Student and TA tables
		else echo $userNotFound = "<h3> No such user found, please try again or register!</h3>";
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
	<div class="animsition1" >

		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="#">Moodle 2.0</a>
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
        <div class="container" style="margin-bottom: 275px;">
            <h1>Login Page</h1><br>
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
            <br>
            <input type='submit' value='Enter' name='logbtn' class="btn btn-default"/>
        </form>
        </div>
		<footer class="container-fluid bg-4 text-center" style="padding: 5px 0 0 0 ;">
            <p>SOEN 341 project, Winter 2017.</p>
			<p>Copyright 2017 SOEN341 Project.</p>
			<p>Contact us: 1800-123-4567 Proud company since 2017</p>

		</footer>
	</div>
	<script src="../../js/jquery-1.11.2.min.js"></script>
	<script src="../../js/animsition/animsition.min.js"></script>
	<script src="../../js/sticky/jquery.sticky.js"></script>
	<script src="../../js/main.js"></script>
	</body>
</html>



