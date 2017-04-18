<?php
	require_once '../../sql_connect.php';
	require_once '../functions.php';
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
	<!--<div class="animsition">-->
		<nav class="navbar navbar-inverse ">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand">Moodle 2.0</a>
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
						<select class="form-control" id="sel1" name="sel1"  onchange="dropdown()" required>
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

		<?php
			function classDropdown(){
				global $dbc;
				$queryFindClasses = "SELECT * FROM ClassList";
				$passQuery = mysqli_query($dbc , $queryFindClasses);
				$classes_sections = array();
				$inc = 0;
			  $together = "";

				while( $rowAllClasses = mysqli_fetch_assoc( $passQuery)){

					++$inc;
					$classes_sections[] =
					"var classText". $inc . " = document.createTextNode(\"" .  $rowAllClasses['class'] . " " . $rowAllClasses['section'] . "\");
					var optionClass". $inc ." = document.createElement(\"option\");
					optionClass". $inc .".appendChild(classText". $inc .");
					selectClass.appendChild(optionClass". $inc .");";
				}
				//looping through all classes + sections and storing it as one long string into $together
				for ($key = 0, $size = count($classes_sections); $key < $size; $key++) {
					$together .= $classes_sections[$key] . " ";
				}

				echo
				'<script>
					document.onload = dropdown();
					function dropdown(){
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
							var label = document.createElement("label");
							var p = document.createElement("p");
							var text = document.createTextNode("Enter your class and section:");
							p.appendChild(text);
							label.appendChild(p);
							div.appendChild(label);

							//creating Class dropdown selection
							var number1 = i + 1;
							var selectClass = document.createElement("select");
							selectClass.className = "form-control";
							selectClass.placeholder = "Class";
							selectClass.name = "c" + number1;

							' . $together . '

							div.appendChild(selectClass);
							container.appendChild(div);
            }
					}
		</script>';
		}

		function accountValidation(){
				global $dbc;
				//gets user input
				if(isset($_POST['register'])){


					$id = $_POST['id'];
					$name = $_POST['fullName'];
					$email = $_POST['email'];
					$password = $_POST['password'];
					$repassword = $_POST['repassword'];
					$classList = array();
					for($i = 1; $i <= $_POST["sel1"]; $i++){
						$c = "c$i";
						if(isset($_POST[$c])){
							$classList[] = $_POST[$c];
						}
					}

					$result = attemptRegistration($id, $name, $email, $password, $repassword, $classList, $dbc);
					echo $result;
				}
			}

			classDropdown();
			accountValidation();
			?>
	<!--</div>-->
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
