<?php 
	require_once '../../sql_connect.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Create Account</title>
		<meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="../../css/createAccount.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
						<li class = "active"><a href="createAccount.php"><span class="glyphicon glyphicon-user"></span> Create Account</a></li>
						<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
						<li><a href="about.php"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
            <h1>Register Page</h1>
				<form id='createAccount' action='' method='post'>
                    <div class="form-group">
				        <label><p>Enter your Concordia ID:</p></label>
				            <input type='text' name='id' class="form-control" placeholder='Concordia ID' required/>
                    </div>
                    <div class="form-group">
						<label><p>Enter your full name:</p></label>
				        <input type='text' name='fullName' class="form-control" placeholder='Full Name' required/>
                    </div>
                    <div class="form-group">
						<label><p>Enter your email:</p></label>
						<input type='email' name='email' class="form-control" placeholder='Email Address' required/>
                    </div>
                    <div class="form-group">
						<label><p>Create a Password:</p></label>
						<input type='password' name='password' class="form-control" placeholder='Password' required/>
                    </div>
                    <div class="form-group">
						<label><p>Confirm Password:</p></label>
						<input type='password' name='repassword' class="form-control" placeholder='Password' required/>
                    </div>
                    <br>
                    <label class="checkbox-inline"><input type="checkbox" value="" name='accountType'>Teacher's Assistant</label>
                    <label class="checkbox-inline"><input type="checkbox" value="" name='accountType'>Student</label><br><br>
                    <button type="submit" value = 'Submit' name='register' class="btn btn-default">Submit</button>
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
		<footer class="container-fluid bg-4 text-center">
            <p>SOEN 341 project, Winter 2017.</p>
			<p>Copyright 2017 SOEN341 Project.</p>
			<p>Contact us: 1800-123-4567 Proud company since 2017</p>

		</footer>
	</body>
</html>
