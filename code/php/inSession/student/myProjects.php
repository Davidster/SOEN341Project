<?php
require_once '../../../sql_connect.php';
	session_start();
	if(isset($_SESSION['logon'])){
		if(!$_SESSION['logon']){ 
			header("Location: ../../index/home.php");
			die();
		}
	}
	else{
		header("Location: ../../index/home.php");
	}

	//check if TA user is logged in
	$TA= false;
	if(isset($_SESSION['ta'])){
		$GLOBALS['TA'] = true;
	}
?>
	<!DOCTYPE html>
<html>
	<head>
		<title>Log in</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../../css/index.css"/>

		<!-- Import JQuery library (REMOVE THIS COMMENT AT SOME POINT) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

		<link rel="shortcut icon" href="../../../pictures/favicon.ico" type="image/x-icon">
		
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
					<a class="navbar-brand" href="../myProfile.php">Moodle 2.0</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="../myProfile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
						<li class = "active"><a href="myProjects.php"><span class="glyphicon glyphicon-folder-open"></span> My Projects</a></li>';	
						<li><a href="../chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
						<li><a href="../logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			<?php 
				echo $_SESSION['name']. "</br>";
				echo $_SESSION['email']. "</br>";
				if($TA) echo $_SESSION['ta'];
				else echo $_SESSION['sid'];
			?>
		</div>
		<div class="container">
		<?php
				
				
				if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
					$fileName = $_FILES['userfile']['name'];
					$tmpName  = $_FILES['userfile']['tmp_name'];
					$fileSize = $_FILES['userfile']['size'];
					$fileType = $_FILES['userfile']['type'];
					$pid = $_POST['pid'];

					$fp = fopen($tmpName, 'r');
					$content = fread($fp, filesize($tmpName));
					$content = addslashes($content);
					fclose($fp);

					if(!get_magic_quotes_gpc()){
						$fileName = addslashes($fileName);
					}
					//fid is incremented automatically so ignore
					$query = "INSERT INTO Files (pid, fname, size, type, content) 
					VALUES ('$pid', '$fileName', '$fileSize', '$fileType', '$content')";

					mysql_query($query) or die('Error, query failed'); 

					echo "<br>File $fileName uploaded<br>";

				} 
			?>
			</br></br>
			<form method="post" enctype="multipart/form-data">
				<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
					<tr> 
						<td width="246">
							<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
							<input name="userfile" type="file" id="userfile" required> 
							<input name="pid" type="text" id="pid" required> 
						</td>
						<td width="80">
							<input name="upload" type="submit" class="box" id="upload" value=" Upload ">
						</td>
					</tr>
				</table>
			</form>
		</div>	
		<footer>
			<div class="legal">SOEN 341 project, Winter 2017.</div>
			<div class="legal">Copyright 2017 SOEN341 Project.</div>
			<div class="contact">Contact us: 1800-123-4567 Proud company since 2017</div>

		</footer>		
	</body>
</html>

