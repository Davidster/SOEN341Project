<?php 

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
		$maxUploadSize = 50000;

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
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
		else {
			echo "File above the 50kb limit. Did not upload";
		}
	}

?>