<?php
require_once 'sql_connect.php';
require_once dirname(__FILE__)."/phpfreechat-1.7/src/phpfreechat.class.php";
$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
$chat = new phpFreeChat($params);
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
			<?php 
				include ('php/index/homepage.php');
				include ('php/index/contactPage.php');
				include ('php/index/coursePage.php');
			?>
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