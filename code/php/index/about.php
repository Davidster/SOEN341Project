<!DOCTYPE html>
<html>
	<head>
		<title>About</title>
		<meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="../../css/about.css"/>
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
						<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
						<li class = "active"><a href="about.php"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>
					</ul>
				</div>
			</div>
		</nav>

         <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8">
                    <h2>About Page</h2>
                    <h4>About Us</h4> 
                    <p>We are a team of students in Software engineering and Computer engineering. Inspired by the idea of having a site dedicated to group projects, we decided to built a webstite that would contains all the features needed to work on the given project.</p>
            <button class="btn btn-default btn-lg">Get in Touch</button>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-signal logo"></span>
                </div>
            </div>
        </div>

        <div class="container-fluid bg-grey">
            <div class="row">
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-globe logo"></span> 
                </div>
            <div class="col-sm-8">
                <h2>Our Values</h2>
                <h4><strong>MISSION:</strong> Our mission is to provide a simple and useful web platform for group projects. This interface can be use for both, students and teacher's assistants, and supplies a good way to interact within the team and with the teacher assistant.</h4> 
            </div>
            </div>
        </div>
        
        <div class="container-fluid text-center">
            <a href="#myPage" title="To Top">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a>
            <p class="github-link">To know more about our project, please visit our <a href="https://github.com/Davidster/SOEN341Project.git">GitHub repository</a></p> 
        </div>
        
		<footer class="container-fluid bg-4 text-center">
            <p>SOEN 341 project, Winter 2017.</p>
			<p>Copyright 2017 SOEN341 Project.</p>
			<p>Contact us: 1800-123-4567 Proud company since 2017</p>

		</footer>		
	</body>
</html>
