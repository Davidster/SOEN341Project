<?php
	session_start();
	require_once '../../sql_connect.php';
	if(isset($_SESSION['logon'])){
		if(!$_SESSION['logon']){ 
			header("Location: ../index/home.php");
			die();
		}
	}
	else{
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

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Upload/Download</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="../../css/index.css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../js/animsition/animsition.min.css">
		<link rel="stylesheet" type="text/css" href="../../css/uploadDemo.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!-- <script src="../../js/jquery-1.11.2.min.js"></script> -->
		<script src="../../js/animsition/animsition.min.js"></script>
		<script src="../../js/sticky/jquery.sticky.js"></script>
		<script type="text/javascript" src="../../js/main.js"></script>
		<script type="text/javascript">
			var $j = jQuery.noConflict();

			$j(document).ready(function(){
			    $j("a[href='logOut.php']").click(function(e){
			  		//call the internal disconnect function of phpfreechat
					pfc.connect_disconnect();
			    });
			});
		</script>
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
						<a class="navbar-brand" href="myProfile.php">Moodle 2.0</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li><a href="myProfile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
							<li><a href="chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
							<li><a href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<div id="page-content">
				<div class="container">
					<div class="container-fluid">
						<form method="post" enctype="multipart/form-data" class="uploadForm">
							<table width="350" border="0" cellpadding="1" cellspacing="1" class="uploadTable">
								<tr> 
									<td width="246">
										<input type="hidden" name="MAX_FILE_SIZE" value="50000">
										<input name="file" type="file" id="file" class="fileInput" required> 
										<?php if(!$TA)echo "<input type='text' name='pid' placeholder='Project ID' value='205' required>";?>
										<?php if(!$TA)echo "<input type='text' name='class' placeholder='Class' value='SOEN341' required>";?>
										<?php if(!$TA)echo "<input type='text' name='section' placeholder='Section' value='AA' required>";?>
													
									</td>
									<td width="80">
										<input name="upload" type="submit" class="uploadButton" id="upload" value=" Upload ">
									</td>
								</tr>
							</table>
							<div id="uploadResults">
								<?php
									if(isset($_POST['upload'])){

										$maxUploadSize = 50000;

										$preFileName = $_FILES['file']['name'];
										$tmpName  = $_FILES['file']['tmp_name'];
										$fileSize = $_FILES['file']['size'];

										if($fileSize >= 0 && $fileSize <= $maxUploadSize){

											$finalUploadPath = "";

											if($TA){
												// set TA upload path
												$finalUploadPath = $pathToPublic.$preFileName;
											} else {
												// set Student upload path
												$pid = $_POST['pid'];
												$class = $_POST['class'];
												$section = $_POST['section'];
												$filePrefix = $pid."-".$class."-".$section."-";

												$finalUploadPath = $pathToUploads.$filePrefix.$preFileName;
											}

											// upload the file
											if (move_uploaded_file($tmpName, $finalUploadPath)) {
										        echo "The file ". basename($preFileName). " has been uploaded.";
										    } else {
										        echo "Sorry, there was an error uploading your file.";
										    }
										} 
										else {
											echo "File above the 50kb limit. Did not upload";
										}
									}								
								?>
							</div>
						</form>
						<table width="500px" border="0" cellpadding="1" cellspacing="1" class="fileTable" >
							<tr>
								<td width ="246" class="fileUploads"></td>
								<td width="50" class="removeButton"><td>
							</tr>
						</table>
					</div>	
					<div id="fileDownload">
						<?php
							function addFileLink($filePath, $fileName){
								echo "<a href='".$filePath.$fileName."' target='_blank' download>".$fileName."</a>";
							}
							function listFilesInDir($dir){
								if ($handle = opendir($dir)) {
								    while (false !== ($entry = readdir($handle))) {
								        if ($entry != "." && $entry != ".." && $entry != "public") {
								        	addFileLink($dir, $entry);
								        }
								    }
								    closedir($handle);
								}
							}
						?>
						<div id="publicFiles">
							<h2>Public files:</h2>
							<?php
								listFilesInDir($pathToPublic);
							?>
						</div>
						<div id="classFiles">
							<h2>Course files:</h2>
							<?php
								listFilesInDir($pathToUploads);
							?>
						</div>
					</div>			
				</div>	
			</div>
		</div>
	</body>
</html>