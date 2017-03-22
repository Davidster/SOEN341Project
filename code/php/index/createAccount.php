<?php 
	require_once '../../sql_connect.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Create Account</title>
		<meta charset="UTF-8" />
		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../js/animsition/animsition.min.css">
		<link rel="stylesheet"  href="../../css/createAccount.css" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="animsition1">
		<nav class="navbar navbar-inverse ">
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
						<label><p>Enter your class and section:</p></label>
						<input type='text' name='c1' class="form-control" placeholder='Class' required/>
						<input type='text' name='s1' class="form-control" placeholder='Section' required/>
                    </div>
                    
                    <div class="form-group">
						<label><p>Enter your class and section:</p></label>
						<input type='text' name='c2' class="form-control" placeholder='Class' />
                    	<input type='text' name='s2' class="form-control" placeholder='Section' />
                    </div>
                    
                    <div class="form-group">
						<label><p>Enter your class and section:</p></label>
						<input type='text' name='c3' class="form-control" placeholder='Class' />
                   		<input type='text' name='s3' class="form-control" placeholder='Section' />
                    </div>

                    <div class="form-group">
						<label><p>Enter your class and section:</p></label>
						<input type='text' name='c4' class="form-control" placeholder='Class' />
                    	<input type='text' name='s4' class="form-control" placeholder='Section' />
                    </div>
                    
                    <div class="form-group">
						<label><p>Enter your class and section:</p></label>
						<input type='text' name='c5' class="form-control" placeholder='Class' />
                   		<input type='text' name='s5' class="form-control" placeholder='Section' />
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

					$classes = array();
					$sections = array();


					//check if passwords are exact
					if($password == $repassword){
						//check if id is enrolled student list
						$checkstudent = "SELECT * from StudentList where sid = '$id'";
						$query1 = mysqli_query($dbc, $checkstudent); //pass this query to our db
						$studentfound = mysqli_num_rows($query1); //returns number of found rows

						//check if id is enrolled in class list
						$checkta = "SELECT * from ClassList where ta = '$id'";
						$query2 = mysqli_query($dbc, $checkta); //pass this query to our db
						$tafound = mysqli_num_rows($query2); //returns number of found rows


						//student input
						if($studentfound == 1){

							$register = "INSERT INTO Student (sid, name, email, password) VALUES ('$id','$name','$email', '$password')";

							
							//create student record
							if(mysqli_query($dbc, $register)){
								//look through all his classes input
								for($i = 1; $i <= 5; $i++){
								$s = "s$i";
								$c = "c$i";
								if(isset($_POST[$c]) && isset($_POST[$s])){
									$class = $_POST[$c];
									$section = $_POST[$s];
									//find ta for that class and section
									$returnta = mysqli_query($dbc, "SELECT * FROM ClassList WHERE class='$class' && section='$section'");
									
									$row = mysqli_fetch_assoc($returnta);
									$t = $row['ta'];
									$p= 0;
									//place the student in the TAs class
									$createproj = "INSERT INTO Project(sid, ta, pid) VALUES ('$id','$t','$p')";
									mysqli_query($dbc, $createproj);
								}
							}
								$success = "<h2>Record created successfully!</h2>";
							}

							else{
							echo "<h2> Sorry. This Concordia ID is already registered in the system</h2>";
							}
						}
						//registers a TA
						else if($tafound == 1 ){

							//find TAs class and section
							$row = mysqli_fetch_assoc($query2);
							$class = $row['class'];
							$section = $row['section'];

							$register = "INSERT INTO Ta (ta, class, section, name, email, password) VALUES ('$id','$class', '$section','$name','$email', '$password')";

							if(mysqli_query($dbc, $register)){
								$success = "<h2>Record created successfully!</h2>";
							}
							else{
							echo "<h2> Sorry. This Concordia ID is already registered in the system</h2>";
							}
						
						}
						else echo "<h2> Sorry, you are not enrolled in our database! </h2>";
					}

					else{
						$passdontmatch = "<h2> The passwords you entered do not match. Try again.</h2>";
					}
				}
				if (isset($success)) {echo $success;}
				if (isset($passdontmatch)) {echo $passdontmatch;}
			?>	
		<footer class="container-fluid bg-4 text-center" style="padding: 5px 0 0 0;">
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
