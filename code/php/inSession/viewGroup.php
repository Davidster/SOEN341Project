<?php
	if(session_id() == '' || session_status() == PHP_SESSION_NONE) {
    	session_start();
	}
	require_once '../../sql_connect.php';
	require_once '../functions.php';
	if(!isset($_SESSION['logon'])){
		//destroy the session
		$_SESSION = array();
		session_destroy();

		//Ensure that the cookie is destructed by setting a date in the past
		setcookie(session_name(), false, time() - 3600);

		header("Location: ../index/home.php");
		}

	//check if TA user is logged in
	$TA = false;
	if(isset($_SESSION['ta'])){
		$GLOBALS['TA'] = true;
	}
	
	
	// setup upload variables
	$pathToUploads = "../../uploads/";
	$pathToPublic = $pathToUploads."public/";

	// add uploads directory if we don't already have it
	if (!file_exists($pathToUploads)) {
	    mkdir($pathToUploads, 0755, true);
	}

	// add public directory if we don't already have it
	if (!file_exists($pathToPublic)) {
	    mkdir($pathToPublic, 0755, true);
	}
	
	function addFileLink($filePath, $fileName){
		return "<a href='".$filePath.$fileName."' target='_blank' download>".$fileName."</a><br/>";
	}

	function listFilesInDir($dir){
		$res = 'None';
		if ($handle = opendir($dir)) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != ".." && $entry != "public") {
		        	if($res == "None"){
		        		$res = '';
		        	}
		        	$res = $res.addFileLink($dir, $entry);
		        }
		    }
		    closedir($handle);
		}
		return $res;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Log in</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../css/viewGroup.css"/>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script type="text/javascript">
			var $j = jQuery.noConflict();

			$j(document).ready(function(){

			    $j("a[href='logOut.php']").click(function(e){
			  		//call the internal disconnect function of phpfreechat
					pfc.connect_disconnect();
			    });
			});
		</script>
		<link rel="shortcut icon" href="../../../pictures/favicon.ico" type="image/x-icon">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../js/animsition/animsition.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>

	<body>
	<div class="animsitionMyProfile">
		<nav class="navbar navbar-inverse">
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
						<li><a href="myProfile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
						
						    <li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-globe"></span> Groups
								<span class="caret"></span></a>
								<ul class="dropdown-menu">
								
								<?php 
								if($TA){
										$ta = $_SESSION['ta'];
										$queryStudents = mysqli_query($dbc, "SELECT * FROM Project WHERE ta = '$ta'");
										$rowAllStudents = mysqli_fetch_assoc($queryStudents);
										$numberOfStudents = mysqli_num_rows($queryStudents);

										$queryNumGroups = mysqli_query($dbc, "SELECT DISTINCT pid FROM Project WHERE ta = '$ta'");
										$rowGroups= mysqli_fetch_assoc($queryNumGroups);
										$numOfGroups = mysqli_num_rows($queryNumGroups);


										if($numOfGroups > 1){
											//for each group display students of that group
											for($i = 1; $i<=$numOfGroups; $i++){
												$queryOneGroup = mysqli_query( $dbc,"SELECT * FROM Project WHERE ta = '$ta' AND pid = '$i'");
												echo "<li><a href='viewGroup.php'> Team $i </a></li>";

												}	
												
											}
								}
								else {
									
									
										for($i=1;$i<=$_SESSION['total'];$i++){
										$c = "class$i";
										$s = "section$i";
										echo "<li><a href='viewGroup.php'>$_SESSION[$c]$_SESSION[$s]</a></li>";
										}
								}
								
								?>
									

									</ul>
							</li>
						
						
						
						<li><a href="chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
						<li><a href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div id="page-content">


		<div class="col-sm-12"><div class="crossfade"><figure></figure><figure></figure><figure></figure><figure></figure><figure></figure></div></div>
		<div class="col-sm-12"><div class="jumbotron text-center"><div class="panel-body">
		
		
		 <h1>GROUP PAGE </h1>
		 
		 <span class="glyphicon glyphicon-user gi-4x"></span> <span class="glyphicon glyphicon-user gi-4x"></span> <span class="glyphicon glyphicon-user gi-4x"></span>
		 
		 
		 
		<p>Here is where you will be able to upload and download the files for your project.</p>
		
            </div></div></div>
		

							
				
		

		<div class="row" align="center">
		<!-- COL 1 -->
            <div class="col-sm-3"></div>
			<div class="col-sm-6"> <span class ="glyphicon glyphicon-file"></span><div class="panel panel-default text-center"><div class="panel-heading"><h1>Uploaded Files</h1></div><div class="panel-body">
		
                <p> <b>UPLOADED BY TA</b></p>

                	<div id="taUploadList"></div>
							
                <p><b>UPLOADED BY STUDENT</b></p>

					<div id="studentUploadList"></div>		
					
			
			</div></div></div>
            <div class="col-sm-3"></div>
            </div>
			
			
			<!-- COL 2 -->

            
            <div class="row" align="center">
                <div class="col-sm-3"></div>
				<div class="col-sm-6"> <span class ="glyphicon glyphicon-list-alt"></span><div class="panel panel-default text-center"><div class="panel-heading"><h1>Names and emails</h1></div><div class="panel-body">
			
			<?php

			if(!$TA){
			//displays all students from each group of each class
					for( $i = 1; $i <= $_SESSION['total']; $i++){		//reiterates over my classes
						//find my TA first
						$c = "class$i";
						$s = "section$i";
						$c = $_SESSION[$c];
						$s = $_SESSION[$s];
						$p = "project$i";
						$p = $_SESSION[$p];
						$queryFindTA = mysqli_query($dbc, "SELECT * FROM ClassList WHERE class = '$c' AND section = '$s'");
						$rowTA = mysqli_fetch_assoc($queryFindTA);
						$myTA = $rowTA['ta'];
						// second find my teamates
						$queryFindTeamates = mysqli_query($dbc, "SELECT * FROM Project WHERE ta = '$myTA' AND pid ='$p'");
						echo "<br/><h5><b>TEAM for ".$c."".$s. " ".$p." :</h5></b>";
						while( $rowTeam = mysqli_fetch_assoc($queryFindTeamates)){

							$sid = $rowTeam['sid'];
							//find that students name and email
							$queryStudentInfo = mysqli_query($dbc, "SELECT * FROM Student WHERE sid = '$sid'");
							$rowStudent = mysqli_fetch_assoc($queryStudentInfo);
							$name = $rowStudent['name'];
							$email = $rowStudent['email'];
							echo "<p><b>Student Name:</b> " .$name . " </br><b>Student ID:</b> ". $sid . " </br><b>Student Contact:</b> " . $email . "</p></br>";
						}

					}
			}
			else {
				if($TA){

 					echo "<b>".$_SESSION['class']." ".$_SESSION['section']."</b></br>";
 					$ta = $_SESSION['ta'];
 					$result = mysqli_query($dbc,"SELECT * FROM Project WHERE ta='$ta'");

 					while( $row = mysqli_fetch_assoc($result)){
 						echo "<b>Student ID:</b> ". $row['sid']. "</br>";
 					}
				}
			}

			?>
			
			<div class="col-sm-3"></div>
			
			</div></div></div></div>
			<!-- COL 3 -->

			
			</div>
			<!--second row-->
			<div class="row" align="center">
			
			<div class="col-sm-3"></div>
	   
			<div class="col-sm-6"> <span class ="glyphicon glyphicon-cloud-upload " ></span><div class="panel panel-default text-center"><div class="panel-heading"><h1>Upload a file (Max 1MB)</h1></div><div class="panel-body">
					
			
						<form method="post" enctype="multipart/form-data" class="uploadForm">
							<table width="350" border="0" cellpadding="1" cellspacing="1" class="uploadTable">
								<tr>
									<td width="246">
										<input name="file" type="file" id="file" class="fileInput" required>
										<?php if(!$TA)echo "<input type='text' name='pid' placeholder='Project ID' value='205' required>";?>
										<?php if(!$TA)echo "<input type='text' name='class' placeholder='Class' value='SOEN341' required>";?>
										<?php if(!$TA)echo "<input type='text' name='section' placeholder='Section' value='AA' required>";?>

									</td>
									<td width="80">
										<input name="upload" type="submit" class="uploadButton" id="upload" value="Upload ">
									</td>
								</tr>
							</table>
							<div id="uploadResults">
								<?php
									if(isset($_POST['upload'])){

										$preFileName = $_FILES['file']['name'];
										$tmpName  = $_FILES['file']['tmp_name'];
										$fileSize = $_FILES['file']['size'];
										if(!$TA){
											$pid = $_POST['pid'];
											$class = $_POST['class'];
											$section = $_POST['section'];
											uploadFile($preFileName, $tmpName, $fileSize, $pid, $class, $section, $TA, $pathToUploads, $pathToPublic);
										} else {
											uploadFile($preFileName, $tmpName, $fileSize, '', '', '', $TA, $pathToUploads, $pathToPublic);
										}
									}

									$taUploadList = listFilesInDir($pathToPublic);
									$studentUploadList = listFilesInDir($pathToUploads);

									// make sure we update the file upload list after files have been uploaded
									echo '<script> 
											$j("#taUploadList").html("'.$taUploadList.'");
											$j("#studentUploadList").html("'.$studentUploadList.'");
										 </script>';

								?>
							</div>
						</form>
						<table width="500px" border="0" cellpadding="1" cellspacing="1" class="fileTable" >
							<tr>
								<td width ="246" class="fileUploads"></td>
								<td width="50" class="removeButton"><td>
							</tr>
						</table>
	
					<div id="fileDownload">



					</div>

		</div></div></div></div></div>


		   <br/><br/><br/><br/> <!-- ROW -->
        <footer style="background-color: #222222;padding: 25px 0;color: rgba(255, 255, 255, 0.3);text-align: center;position:relative;top:-20px;">
			<div class="container">
				<p style="font-size: 12px; margin: 0;">&copy; Winter 2017 SOEN341 Project. All Rights Reserved.
				<br/>Contact Us: 1-800-123-4567
				</p>
			</div>
        </footer>



	<script src="../../js/jquery-1.11.2.min.js"></script>
	<script src="../../js/animsition/animsition.min.js"></script>
	<script src="../../js/sticky/jquery.sticky.js"></script>
	<script type="text/javascript" src="../../js/main.js"></script>

	</body>
</html>
