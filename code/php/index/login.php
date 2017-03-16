<?php
	session_start();
	$_SESSION['logon'] = false;
	require_once '../../sql_connect.php';

	//authentification
	if(isset($_POST['logbtn'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$dbsearch = "SELECT * FROM Ta where email = '$email'";
		$query = mysqli_query($dbc, $dbsearch); //pass this query to our db
		$found = mysqli_num_rows($query); //returns number of found rows

		//checks if entry is found in TA TABLE
		if($found == 1){
			$row = mysqli_fetch_assoc($query);
			$dbname = $row['name'];
 			$dbpassword = $row['password'];
 			$dbemail = $row['email'];
 			$dbtid = $row['ta'];
 			$dbclass = $row['class'];
 			$dbsection = $row['section'];
			//password is correct
			if($password == $dbpassword){
				$_SESSION['name'] = $dbname;
				$_SESSION['email'] = $dbemail;
 				$_SESSION['ta'] = $dbtid;
 				$_SESSION['class'] = $dbclass;
 				$_SESSION['section'] = $dbsection;
				$_SESSION['logon'] = true;

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
				$dbemail = $row['email'];
				$dbsid = $row['sid'];
				//password is correct
				if($password == $dbpassword){
					$_SESSION['name'] = $dbname;
					$_SESSION['email'] = $dbemail;
					$_SESSION['sid'] = $dbsid;
					$_SESSION['logon'] = true;
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
        <link rel="stylesheet" type="text/css" href="../../css/login.css"/>
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
        <div class="container">
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
            <input type='submit' value='Enter' name='logbtn'/>
        </form>
        </div>
		<footer class="container-fluid bg-4 text-center">
            <p>SOEN 341 project, Winter 2017.</p>
			<p>Copyright 2017 SOEN341 Project.</p>
			<p>Contact us: 1800-123-4567 Proud company since 2017</p>

		</footer>		
	</body>
</html>



