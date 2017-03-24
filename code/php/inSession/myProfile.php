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
	require_once '../../sql_connect.php';
	//require_once dirname(__FILE__)."../../phpfreechat-1.7/src/phpfreechat.class.php";
	//$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
	//$params["nick"] = $_SESSION['name'];
	//$chat = new phpFreeChat($params);

	//check if TA user is logged in
	$TA= false;
	if(isset($_SESSION['ta'])){
		$GLOBALS['TA'] = true;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>personal page</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../css/index.css"/>
		<link rel="stylesheet" href="../../css/style.css" />

		<!-- Import JQuery library (REMOVE THIS COMMENT AT SOME POINT) -->
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
					<a class="navbar-brand" href="myProfile.php">Moodle 2.0</a>
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
		
		<div class="profile" align= "center">
	
			<?php 
					echo '<span style="front-size: 45px;front-family: Helvetica;color: #7B7A7A;">Welcome to your portal ' .$_SESSION['name']. '!</span></br>';
					echo '<span style="front-size: 25px;front-family: Helvetica;color: #7B7A7A;">email: '.$_SESSION['email']. '</span></br>';
				if($TA){
					echo $_SESSION['class'];
					echo $_SESSION['section']."</br>";
					$ta= $_SESSION['ta'];
					$query1 = mysqli_query($dbc,"SELECT * FROM Project WHERE ta='$ta'");
					$classSize = mysqli_num_rows($query1);
					echo "Number of Students: ". $classSize;
					echo "</br>";
					//if teams are made
					$query2 = mysqli_query($dbc,"SELECT 1 FROM Project WHERE ta= '$ta' AND pid='0'");
					if(mysqli_num_rows($query2)==0){
						while( $row = mysqli_fetch_assoc($query1)){
							echo "Student: ". $row['sid']. " Team #: ". $row['pid']. "</br>";
						}
					}
					//teams are not made yet
					else{
						$query3= mysqli_query($dbc,"SELECT * FROM Project WHERE ta= '$ta' ORDER BY pid ASC");
						while( $row = mysqli_fetch_assoc($query1)){
							echo "Student: " . $row['sid']."</br>";
							
						}
					}

					echo "<div>
				<form id='make' action= '' method='post'>
				<input type='text' name='teamsOf' placeholder= 'team size' required>
				<input type='submit' value='Create Teams' name='make'>
				</form>
			</div>

			<div>
				<form id='undo' action='' method ='post'>
				<input type='submit' value='Undo Teams' name='undo'>
			</div>	";
				}
				else{
					echo $_SESSION['sid'];
				}


				if($TA){
					//find all students in TAs class
 					$query = mysqli_query($dbc, "SELECT * FROM Project WHERE ta = '$ta'");

					if(isset($_POST['make'])){
						$teamSize = $_POST['teamsOf'];
						$numOfTeams = ceil($classSize / $teamSize);
						//$extraStudents = ($classSize % $teamSize);
						//creates groups by joining the next number of students on the same team
						$count=0;
						$i=0;
						while($row = mysqli_fetch_assoc($query)){
							if(($count++ % $teamSize)==0){
								$i++;
							}
						$student = $row['sid'];
						mysqli_query($dbc, "UPDATE Project SET pid ='$i' WHERE sid = '$student' AND ta= '$ta'");
					
						}
						if($i== $numOfTeams){
							echo "<h2> Succesfully created $i teams";
						}
					}

				if(isset($_POST['undo'])){
					while($row = mysqli_fetch_assoc($query)){
						mysqli_query($dbc, "UPDATE Project SET pid ='0' WHERE ta= '$ta'");
					}
					echo "<h2>Deleted groups</h2>";
				}
			}
			//upload apge
			echo "<a href='viewGroup.php'>
			   <input type='button' value='upload'class='button' />
			</a>";

			?>
			
<title>Download Files</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php
for($i=1;$i<=$_SESSION['total'];$i++){
	$c= "class$i";
	$s= "section$i";
	$p= "project$i";
	$c= $_SESSION[$c];
	$s= $_SESSION[$s];
	$p= $_SESSION[$p];
	$sid= $_SESSION['sid'];
$query = "SELECT * FROM ClassList WHERE class='$c' AND section='$s'";
$result = mysqli_query($dbc,$query);
$row= mysqli_fetch_assoc($result);
$ta= $row['ta'];
echo "</br> Class: $c $s ";

echo "Files:";

$files= mysqli_query($dbc, "SELECT * FROM Files WHERE (ta= '$ta' AND pid= '$p') OR (ta= '$ta' AND pid = null)");

while($rows = mysqli_fetch_assoc($files)){
$fid= $rows['fid'];
echo $fid;
$fname=$rows['fname'];
echo $fname;
$fid= urlencode($fid);
$fname= urlencode($fname);
echo "<a href='myProfile.php?fid=$fid'> $fname</a> </br>";
 
}
}

if(isset($_GET['fid'])) 
{
// if id is set then get the file with the id from database

$fid    = $_GET['fid'];
$query = "SELECT fname, type, size, content " .
         "FROM Files WHERE fid = '$fid'";

$result = mysqli_query($query) or die('Error, query failed');
$row =  mysqli_fetch_assoc($result);

header("Content-length: {$row['size']}");
header("Content-type: {$row['type']}");
header("Content-Disposition: attachment; filename={$row['fname']}");
echo $row['content'];
exit;
}


?>


			

<!--

			<input value=?php $row['sid'] ?> type="hidden" name="search">
			
			<h1> SOEN341AA </h1>
			
			<a href="viewGroup.php">
			   <input type="button" value="200"class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="201" class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="202"class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="203"class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="204"class="button" />
			</a>
			<a href="viewGroup.php">
			   <input type="button" value="205"class="button" />
			</a>








-->

		
			<!--<div id="livechat-page" style="display: block;">
				/*
				
				php $chat->printChat(); ?>
				
				*/
			</div>-->
				
		
		<footer class="end">
			
			<div>Running into issues? Please contact us: 1800-123-4567.</div>

		</footer>
		   
	</body>
</html>