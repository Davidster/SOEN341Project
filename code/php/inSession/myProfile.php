<?php
	session_start();
	require_once '../../sql_connect.php';
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
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Personal page</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../css/myProfile.css"/>

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
		<link rel="shortcut icon" href="../../pictures/favicon.ico" type="image/x-icon">

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
						<li class = "active"><a href="myProfile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
						<li><a href="chat.php"><span class="glyphicon glyphicon-comment"></span> Chat</a></li>
						<li><a href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="row" align="center">

			<?php


				if($TA){

				echo '<span style="front-size: 45px;front-family: Helvetica;color: #7B7A7A;"><h2>Welcome to your portal ' .$_SESSION['name']. '!</h2></span></br>';
				echo '<span style="front-size: 25px;front-family: Helvetica;color: #7B7A7A;">email: '.$_SESSION['email']. '</span></br>';
					echo $_SESSION['class'];
					echo $_SESSION['section']."</br>";
					$ta = $_SESSION['ta'];
					$projQueryRes = mysqli_query($dbc,"SELECT * FROM Project WHERE ta='$ta'");
					$classSize = mysqli_num_rows($projQueryRes);
					echo "Number of Students: ". $classSize;
					echo "</br>";
					//if teams are made
					$projQueryRes2 = mysqli_query($dbc,"SELECT 1 FROM Project WHERE ta= '$ta' AND pid='0'");
					if(mysqli_num_rows($projQueryRes2) == 0){
						while( $row = mysqli_fetch_assoc($projQueryRes)){
							//echo "Student: ". $row['sid']. " Team #: ". $row['pid']. "</br>";
						}
					}
					//teams are not all made yet
					else{
						$projQueryRes3 = mysqli_query($dbc,"SELECT * FROM Project WHERE ta= '$ta' ORDER BY pid ASC");
						while( $row = mysqli_fetch_assoc($projQueryRes)){
							echo "Student: " . $row['sid']. " Team #: ".$row['pid'] ."</br>";

						}
					}

					echo 	"<div>
								<form id='make' action= '' method='post'>
									<input type='text' name='teamsOf' placeholder= 'team size' required>
									<input type='submit' value='Create Teams' name='make'>
								</form>
							</div>

							<div>
								<form id='undo' action='' method ='post'>
								<input type='submit' value='Undo Teams' name='undo'>
							</div>	";

					echo 	"<div>
								<form id='add' action= '' method='post'>
									<input type='text' name='sidToAdd' placeholder= 'Insert Student ID' required>
									<input type='text' name='pidA' placeholder= 'Insert Project ID' required>
									<input type='submit' value='Add to Team' name='add'>
								</form>
							</div>

							<div>
								<form id='remove' action= '' method='post'>
									<input type='text' name='sidToRemove' placeholder= 'Insert Student ID' required>
									<input type='submit' value='Remove from Team' name='remove'>
								</form>
							</div>

							";

					//find all students in TAs class
 					$projQueryRes = mysqli_query($dbc, "SELECT * FROM Project WHERE ta = '$ta'");

					if(isset($_POST['make'])){
						$teamSize = $_POST['teamsOf'];
						$numOfTeams = ceil($classSize / $teamSize);
						//$extraStudents = ($classSize % $teamSize);
						//creates groups by joining the next number of students on the same team
						$count = 0;
						$i = 0;
						while($row = mysqli_fetch_assoc($projQueryRes)){
							if(($count++ % $teamSize) == 0){
								$i++;
							}
						$student = $row['sid'];
						mysqli_query($dbc, "UPDATE Project SET pid ='$i' WHERE sid = '$student' AND ta= '$ta'");

						}
						if($i == $numOfTeams){
							echo "<h2> Succesfully created $i teams";
						}
					}

					if(isset($_POST['undo'])){
						//resets all teams to 0
						while($row = mysqli_fetch_assoc($projQueryRes)){
							mysqli_query($dbc, "UPDATE Project SET pid ='0' WHERE ta= '$ta'");
						}
						echo "<h2>Deleted groups</h2>";
					}


					if(isset($_POST['add'])){
						$sidToAdd = $_POST['sidToAdd'];
						$pidA = $_POST['pidA'];

						//check if sid exists for this class
						$studentExists = mysqli_query($dbc, "SELECT EXISTS(SELECT 1 FROM Project WHERE ta ='$ta' AND sid = '$sidToAdd')");
						if(mysqli_num_rows($studentExists) == 0){
							echo "Please enter a valid Student ID";
							break;
						}
						else{
							//change sid to team input
							if(mysqli_query($dbc, "UPDATE Project SET pid ='$pidA' WHERE ta = '$ta' AND sid = '$sidToAdd'")){
								echo "'$sidToAdd' added to '$pidA'";
							}

						}





					}


					if(isset($_POST['remove'])){
						$sidToRemove = $_POST['sidToRemove'];

						//check if sid exists for this class
						$studentExists = mysqli_query($dbc, "SELECT EXISTS(SELECT 1 FROM Project WHERE ta ='$ta' AND sid = '$sidToRemove')");
						if(mysqli_num_rows($studentExists) == 0){
							echo "Please enter a valid Student ID";
							break;
						}
						else{
							//remove sid from team hes in
							if(mysqli_query($dbc, "UPDATE Project SET pid ='0' WHERE ta = '$ta' AND sid = '$sidToRemove'")){
								echo "'$sidToRemove' removed from original team";
							}

						}





					}

// accessing the group pages


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
				echo "</br> Team $i: </br>";
				while($rowGroupedStudents = mysqli_fetch_assoc($queryOneGroup)){
				echo $rowGroupedStudents['sid'] . "</br>";
				}
				echo 	"<a href='viewGroup.php'class=\"button big alt\"> Team $i group page
						</a>";

			}
		}
}
?>


<?php



	if(!$TA){
		echo '<div class="col-sm-12"><div class="crossfade"><figure></figure><figure></figure><figure></figure><figure></figure><figure></figure><span style="front-size: 125px;front-family: Helvetica;color: black;"><h2>YOUR PORTAL</h2></span></div></div></br>';
        
        echo'<div class="col-sm-2"><h2 style="front-size: 50px;front-family: Helvetica;color: white;">My Groups</h2>';
						for($i=1;$i<=$_SESSION['total'];$i++){
						$c = "class$i";
						$s = "section$i";
						echo '<ul class="nav nav-pills nav-stacked" align="left"><li><a href="viewGroup.php">
				        '.$_SESSION[$c].''.$_SESSION[$s].'</a></li>';
						}
        echo'</ul></div>';
        
        echo '<div class="col-sm-5"><h2 style="front-size: 50px;front-family: Helvetica;color: black;">Information</h2><br><p style="front-size: 35px;front-family: Helvetica;color: black;">Student Email: '.$_SESSION['email']. '</p><br><p style="front-size:35px;front-family: Helvetica;color: black;">Student Name: '.$_SESSION['name']. '</p><br><p style="front-size: 35px;front-family: Helvetica;color: black;">Student ID: '.$_SESSION['sid']. '</p></div>';

        echo '<div class="col-sm-5"><h2 style="front-size: 50px;front-family: Helvetica;color: black;">My Courses</h2>';
						for($i = 1; $i <= $_SESSION['total']; $i++){
							$c = "class$i";
							$s = "section$i";
							$p = "project$i";
							$c = $_SESSION[$c];
							$s = $_SESSION[$s];
							$p = $_SESSION[$p];
							$sid = $_SESSION['sid'];
							$classQuery = "SELECT * FROM ClassList WHERE class='$c' AND section='$s'";
							$classQueryRes = mysqli_query($dbc, $classQuery);
							$row = mysqli_fetch_assoc($classQueryRes);
							$ta = $row['ta'];
							echo '</br><p style="front-size: 35px;front-family: Helvetica;color: black;">Class: '.$c.'</br>Section: '.$s.'</br>Project ID: '.$p.'</p>';
						}
        echo'</div>';
	}




?>



	</div>
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
	<script type="text/javascript" src="../../js/main.js"></script>

	</body>

</html>
