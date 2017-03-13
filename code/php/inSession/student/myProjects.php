<?php
	session_start();

	//check if TA user is logged in
	$TA= false;
	if(isset($_SESSION['tid'])){
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
	</head>

	<body>
		<nav>
			<ul class="menu" id="menu">
				<li><a href="../myProfile.php">My Profile</a></li>
				<li><a href="myProjects.php">My Projects</a></li>
				<li><a href="../chat.php">Chat</a></li>
				<li><a href="../logOut.php">Log Out</a></li>
			</ul>
		</nav>
		<div id="page-content">
			<?php 
				echo $_SESSION['name']. "</br>";
				echo $_SESSION['username']. "</br>";
				if($TA) echo $_SESSION['tid'];
				else echo $_SESSION['sid'];
				
				
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
					$query = "INSERT INTO Files (pid, name, size, type, content) 
					VALUES ('$pid','$fileName', '$fileSize', '$fileType', '$content')";

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
							<input name="pid" type="number" id="pid" required> 
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

