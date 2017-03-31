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
	<div class="animsition">
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
			<div class='col-lg-8 col-lg-offset-2'>
				<div class='form-group'>
					<h1>Register Page</h1>
				</div>
				<form id='createAccount' action='' method='post'>
					<div class='form-group'>
						<label><p>Enter your Concordia ID:</p></label>
						<input type='text' name='id' class='form-control' placeholder='Concordia ID' required/>
					</div>
					<div class="form-group">
						<label><p>Enter your full name:</p></label>
						<input type='text' name='fullName' class="form-control" placeholder='Full Name' required/>
					</div>
					<div class="form-group">
						<label><p>Enter your email:</p></label>
						<input type='email' name='email' class="form-control" placeholder='Email Address' required/>
					</div>
					<div class='form-group'>
						<label for="sel1"><p>Select number of classes you're taking:</p></label>
						<select class="form-control" id="sel1" name="sel1"  onchange="hello()" required>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
						<br>
					</div>
					<div id = 'container'>
					</div>
					<div class="form-group">
						<label><p>Create a Password:</p></label>
						<input type='password' name='password' class="form-control" placeholder='Password' required/>
					</div>
					<div class="form-group">
						<label><p>Confirm Password:</p></label>
						<input type='password' name='repassword' class="form-control" placeholder='Password' required/>
					</div>
					<br/>
					<div class="form-group">
						<p><button type="submit" value = 'Submit' name='register' class="btn btn-default">Submit</button></p>
					</div>
				</form><br/><br/>
			</div> 
		</div>	
		<script>
			document.onload(hello());
			function hello(){
				var number = document.getElementById("sel1").value;
            
				// Container <div> where dynamic content will be placed
				var container = document.getElementById("container");
				//var stuff = document.createElement("input");
				//container.appendChild(stuff);
				while (container.hasChildNodes()) {
					container.removeChild(container.lastChild);
				}
				for (i=0;i<number;i++){
					// Create an <input> element, set its type and name attributes
					var div = document.createElement("div");
					div.className = "form-group";
					var label = document.createElement('label');
					var p = document.createElement('p');
					var text = document.createTextNode("Enter your class and section:");
					p.appendChild(text);
					label.appendChild(p);
					div.appendChild(label);
               
					//creating Class dropdown selection
					var number1 = i + 1; 
					var selectClass = document.createElement('select');
					selectClass.className = "form-control";
					selectClass.placeholder = "Class";
					selectClass.name = 'c' + number1;
				
					var classText1 = document.createTextNode("SOEN341");
					var classText2 = document.createTextNode("ENGR201");
				
					var optionClass1 = document.createElement("option");
					var optionClass2 = document.createElement("option");
					
					//optionClass1.disabled = true;
					optionClass1.appendChild(classText1);
					optionClass2.appendChild(classText2);
					
					selectClass.appendChild(optionClass1);
					selectClass.appendChild(optionClass2);

					//creating section dropdown selection	
					var selectSection = document.createElement('select');
					selectSection.className = "form-control";
					selectSection.placeholder = "Section";
					selectSection.name = 's' + number1;

					var sectionText1 = document.createTextNode("AA");
					var sectionText2 = document.createTextNode("BB");
					var sectionText3 = document.createTextNode("XX");
					var sectionText4 = document.createTextNode("YY");
				
					var optionSection1 = document.createElement("option");
					var optionSection2 = document.createElement("option");
					var optionSection3 = document.createElement("option");
					var optionSection4 = document.createElement("option");
				
					//option1.disabled = true;
					optionSection1.appendChild(sectionText1);
					optionSection2.appendChild(sectionText2);
					optionSection3.appendChild(sectionText3);
					optionSection4.appendChild(sectionText4);
				
					selectSection.appendChild(optionSection1);
					selectSection.appendChild(optionSection2);
					selectSection.appendChild(optionSection3);
					selectSection.appendChild(optionSection4);                
				
					div.appendChild(selectClass);
					div.appendChild(selectSection);
					container.appendChild(div);
                }
			}
		</script>
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
						$studentSearchQuery = "SELECT * from StudentList where sid = '$id'";
						$studentQueryRes = mysqli_query($dbc, $studentSearchQuery); //pass this query to our db
						$studentFound = mysqli_num_rows($studentQueryRes); //returns number of found rows

						//check if id is enrolled in class list
						$checkTA = "SELECT * from ClassList where ta = '$id'";
						$taQueryRes = mysqli_query($dbc, $checkTA); //pass this query to our db
						$taFound = mysqli_num_rows($taQueryRes); //returns number of found rows


						//student input
						if($studentFound == 1){

							$registerQuery = "INSERT INTO Student (sid, name, email, password) VALUES ('$id','$name','$email', '$password')";

							
							//create student record
							if(mysqli_query($dbc, $registerQuery)){
								//look through all his classes input
								for($i = 1; $i <= $_POST["sel1"]; $i++){
									$s = "s$i";
									$c = "c$i";
									if(isset($_POST[$c]) && isset($_POST[$s])){
										$class = $_POST[$c];
										$section = $_POST[$s];
										//find ta for that class and section
										$returnedTA = mysqli_query($dbc, "SELECT * FROM ClassList WHERE class='$class' && section='$section'");
										
										$row = mysqli_fetch_assoc($returnedTA);
										$t = $row['ta'];
										$p = 0;
										//place the student in the TAs class
										$createProjQuery = "INSERT INTO Project(sid, ta, pid) VALUES ('$id','$t','$p')";
										mysqli_query($dbc, $createProjQuery);
									}
								}
								$success = "<h2>Record created successfully!</h2>";
							}
							else{
								echo "<h2> Sorry. This Concordia ID is already registered in the system</h2>";
							}
						}
						//registers a TA
						else if($taFound == 1 ){

							//find TAs class and section
							$row = mysqli_fetch_assoc($taQueryRes);
							$class = $row['class'];
							$section = $row['section'];

							$registerQuery = "INSERT INTO Ta (ta, class, section, name, email, password) VALUES ('$id','$class', '$section','$name','$email', '$password')";

							if(mysqli_query($dbc, $registerQuery)){
								$success = "<h2>Record created successfully!</h2>";
							}
							else{
								echo "<h2> Sorry. This Concordia ID is already registered in the system</h2>";
							}
						
						}
						else echo "<h2> Sorry, you are not enrolled in our database! </h2>";
					}
					else{
						$passwordMismatch = "<h2> The passwords you entered do not match. Try again.</h2>";
					}
				}
				if (isset($success)) {echo $success;}
				if (isset($passwordMismatch)) {echo $passwordMismatch;}
			?>	
	</div>
	<footer style="background-color: #222222;padding: 25px 0;color: rgba(255, 255, 255, 0.3);text-align: center;">
		<div class="container">
			<p style="font-size: 12px; margin: 0;">
				&copy; Winter 2017 SOEN341 Project. All Rights Reserved.<br/>
				Contact Us: 1-800-123-4567
			</p>
		</div>
	</footer>
		<script src="../../js/jquery-1.11.2.min.js"></script>
		<script src="../../js/animsition/animsition.min.js"></script>
		<script src="../../js/sticky/jquery.sticky.js"></script>
		<script src="../../js/main.js"></script>
	</body>
</html>
