<?php 

	function attemptRegistration($id, $name, $email, $password, $repassword, $classList, $dbc){

		$result = '';

		//check if passwords are exact
		if($password === $repassword){
			//check if id is enrolled student list
			$studentSearchQuery = "SELECT * from StudentList where sid = '$id'";
			$studentQueryRes = mysqli_query($dbc, $studentSearchQuery); //pass this query to our db
			$studentFound = mysqli_num_rows($studentQueryRes); //returns number of found rows

			//check if id is enrolled in class list
			$checkTA = "SELECT * from ClassList where ta = '$id'";
			$taQueryRes = mysqli_query($dbc, $checkTA); //pass this query to our db
			$taFound = mysqli_num_rows($taQueryRes); //returns number of found rows


			//student input
			if($studentFound == 1){

				$registerQuery = "INSERT INTO Student (sid, name, email, password) VALUES ('$id','$name','$email', '$password')";


				//create student record
				if(mysqli_query($dbc, $registerQuery)){
					//look through all his classes input
					foreach($classList as &$mClass){

						$seperate = (explode(" ", $mClass));
						$class = $seperate[0];
						$section = $seperate[1];

						//find ta for that class and section
						$returnedTA = mysqli_query($dbc, "SELECT * FROM ClassList WHERE class='$class' && section='$section'");

						$row = mysqli_fetch_assoc($returnedTA);
						$t = $row['ta'];
						$p = 0;

						//place the student in the TAs class
						$createProjQuery = "INSERT INTO Project(sid, ta, pid) VALUES ('$id','$t','$p')";
						mysqli_query($dbc, $createProjQuery);
					}
					$result = "<h2>Record created successfully!</h2>";
				}
				else{
					$result = "<h2> Sorry. This Concordia ID is already registered in the system</h2>";
				}
			}
			//registers a TA
			else if($taFound == 1 ){

				//find TAs class and section
				$row = mysqli_fetch_assoc($taQueryRes);
				$class = $row['class'];
				$section = $row['section'];

				$registerQuery = "INSERT INTO Ta (ta, class, section, name, email, password) VALUES ('$id','$class', '$section','$name','$email', '$password')";

				if(mysqli_query($dbc, $registerQuery)){
					$result = "<h2>Record created successfully!</h2>";
				}
				else{
					$result = "<h2> Sorry. This Concordia ID is already registered in the system</h2>";
				}

			}
			else {
				$result = "<h2> Sorry, you are not enrolled in our database! </h2>";
			}
		}
		else{
			$result = "<h2> The passwords you entered do not match. Try again.</h2>";
		}

		return $result;
	}

	function loginUser($email, $password, $dbc, $isTest){
		$emailSearchQuery = "SELECT * FROM Ta where email = '$email'";
		$emailQueryRes = mysqli_query($dbc, $emailSearchQuery); //pass this query to our db
		$emailMatchCount = mysqli_num_rows($emailQueryRes); //returns number of found rows

		//checks if entry is found in TA TABLE
		if($emailMatchCount == 1){
			$row = mysqli_fetch_assoc($emailQueryRes);
			$dbName = $row['name'];
 			$dbPassword = $row['password'];
 			$dbEmail = $row['email'];
 			$dbTID = $row['ta'];
 			$dbClass = $row['class'];
 			$dbSection = $row['section'];
			//password is correct
			if($password == $dbPassword){
				if(!$isTest) {
				    session_start();
				}
				$_SESSION['name'] = $dbName;
				$_SESSION['email'] = $dbEmail;
 				$_SESSION['ta'] = $dbTID;
 				$_SESSION['class'] = $dbClass;
 				$_SESSION['section'] = $dbSection;
				$_SESSION['logon'] = true;

				if(!$isTest) {
					header('location: ../inSession/myProfile.php');
				}
			}
			else echo $passwordMismatch = " <h3> Wrong password, please try again! </h3>";
		}

		//checks if entry is found in Student table
		elseif($emailMatchCount == 0){
			$emailSearchQuery = "SELECT * FROM Student where email = '$email'";
			$emailQueryRes = mysqli_query($dbc, $emailSearchQuery); //pass this query to our db
			$emailMatchCount = mysqli_num_rows($emailQueryRes); //returns number of found rows

			if($emailMatchCount == 1){
				$row = mysqli_fetch_assoc($emailQueryRes);
				$dbName = $row['name'];
				$dbPassword = $row['password'];
				$dbEmail = $row['email'];
				$dbsid = $row['sid'];
				//password is correct
				if($password == $dbPassword){
					if(!$isTest) {
				    	session_start();
					}
					$_SESSION['name'] = $dbName;
					$_SESSION['email'] = $dbEmail;
					$_SESSION['sid'] = $dbsid;
					$_SESSION['logon'] = true;

					$projQueryRes = mysqli_query($dbc, " SELECT * FROM Project WHERE sid = '$dbsid'");
					$totalClasses = mysqli_num_rows($projQueryRes);	//returns number of projects
					$_SESSION['total'] = $totalClasses;

					//store each class, section and matching pid
					for($i = 1; $i <= $totalClasses; $i++){
						$row = mysqli_fetch_assoc($projQueryRes);

						$p = "project$i";
						$_SESSION[$p] = $row['pid'];
						$ta = $row['ta'];

						$classQueryRes = mysqli_query($dbc, "SELECT * FROM ClassList WHERE ta= '$ta'");
						$row2 = mysqli_fetch_assoc($classQueryRes);
						$c = "class$i";
						$s = "section$i";

						$_SESSION[$c] = $row2['class'];
						$_SESSION[$s] = $row2['section'];
					}

					if(!$isTest) {
				    	header('location: ../inSession/myProfile.php');
					}
				}
				else echo $passwordMismatch = " <h3> Wrong password, please try again! </h3>";
			}
		}

		//entry not found in Student and TA tables
		else echo $userNotFound = "<h3> No such user found, please try again or register!</h3>";
	}

	function uploadFile($preFileName, $tmpName, $fileSize, $pid, $class, $section, $TA, $pathToUploads, $pathToPublic){
		$maxUploadSize = 1000000;

		if($fileSize >= 0 && $fileSize <= $maxUploadSize){

			$finalUploadPath = "";

			if($TA){
				// set TA upload path
				$finalUploadPath = $pathToPublic.$preFileName;
			} else {
				// set Student upload path
				$filePrefix = $pid."-".$class."-".$section."-";

				$finalUploadPath = $pathToUploads.$filePrefix.$preFileName;
			}

			// upload the file
			if (move_uploaded_file($tmpName, $finalUploadPath)) {
		        echo "The file ". basename($preFileName). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an unknown error uploading your file.";
		    }
		}
		else {
			echo "File was above the 1MB limit. Did not upload";
		}
	}

?>