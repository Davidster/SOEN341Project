<!DOCTYPE html>
<html>
	<head>
		<title>About</title>
		<meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="../../css/about.css"/>
		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">
     	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../js/animsition/animsition.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!--<script src="jquery-3.2.0.min.js"></script>-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
	<!--<div class="animsition">-->
		

         <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8">
                    <h2>About Page</h2>
                    <h4>About Us</h4> 
                    <p>We are a team of students in Software engineering and Computer engineering. Inspired by the idea of having a site dedicated to group projects, we decided to built a webstite that would contains all the features needed to work on the given project.</p>
            <button class="btn btn-default btn-lg">Get in Touch</button>
            <script>$("button").click(function () {
                        $("#container").append('<div class="container-fluid" style="margin:0px 200px 0px 50px;"><h2 class="text-center">CONTACT</h2><div class="row"><div class="col-lg-5"><p>Contact us and we will get back to you within 24 hours.</p><p><span class="glyphicon glyphicon-map-marker"></span> Montreal, CANADA</p><p><span class="glyphicon glyphicon-phone"></span> 1800-123-4567 </p><p><span class="glyphicon glyphicon-envelope"></span> myemail@something.com</p> </div><div class="col-lg-7"><div class="row"><div class="col-lg-6 form-group"><input class="form-control" id="name" name="name" placeholder="Name" type="text" required></div><div class="col-lg-6 form-group"><input class="form-control" id="email" name="email" placeholder="Email" type="email" required></div></div><textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br><div class="row"><div class="col-lg-12 form-group"><button class="btn btn-default pull-right" type="submit">Send</button></div></div> </div></div></div>');
						$("button").remove();});
            </script>
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
        <div id="container"></div>
        <div class="container-fluid bg-grey text-center" style="margin-bottom:195px;">
            <a href="#myPage" title="To Top">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a>
            <p class="github-link">To know more about our project, please visit our <a href="https://github.com/Davidster/SOEN341Project.git">GitHub repository</a></p> 
        </div>
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
