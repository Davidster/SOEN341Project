<?php
require_once 'sql_connect.php';
//require_once dirname(__FILE__)."/phpfreechat-1.7/src/phpfreechat.class.php";
//$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
//$chat = new phpFreeChat($params);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/index.css"/>
	</head>
	<body>
		<nav>
			<ul class="menu" id="menu">
				<li pagetarget="home-page">Home</li>
				<li pagetarget="login-page">Logout</li>
				<li pagetarget="contact-page">Contact</li>
				<li pagetarget="course-page">Course Page</li>
				<li pagetarget="livechat-page">Chat Test</li>
			</ul>
		</nav>
		<div id="page-content">
			<div id="home-page" style="display: none">
				Home page
			</div>
			
			<div id="course-page" style="display: none;">
			
			
			
				<h2>Courses Page</h2>
				<p>Select the class corresponding to your group project. You will be redirected to the course page.</p>

				<div class="dropdown" >
				  <button class="btn">Courses</button>
				  <div class="content" style="left:0;">
						<a href="#">SOEN 341</a>
						<a href="#">SOEN 490</a>
						<a href="#">SOEN 287</a>
						<a href="#">COEN 390</a>
				  </div>
				</div>			
			</div>
			
			<div id="livechat-page" style="display: block;">
				<?php $chat->printChat(); ?>
			</div>
		</div>
		<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>
	</body>
</html>