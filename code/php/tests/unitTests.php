<?php

require './vendor/autoload.php';
use Guzzle\Http\Client;
	
require_once './code/php/functions.php';

/**
 * This file contains the unit tests for our project
 * 
 * @covers All
 */
final class Test extends \PHPUnit_Framework_TestCase
{

	// When we load the site, we must have a connection to our DB
	public function testDBCExists(){

		require_once './code/sql_connect.php';
		$this->assertEquals(isset($dbc), true);

	}

	// The php pages should be served succesfully
	public function testGET(){

		// Create a client and provide a base URL
		$client = new Client('http://localhost:80');

		$request = $client->get('/code/php/index/home.php');
		echo $request->getUrl();

		// You must send a request in order for the transfer to occur
		$response = $request->send();

		$this->assertEquals('200', $response->getStatusCode());

	}

	// The site should ensure that it has a place to store uploaded files
	public function testUploadFoldersExist(){

		$client = new Client('http://localhost:80');
		$client->get('/code/php/inSession/viewGroup.php')->send();

		$pathToUploads = "./code/uploads/";
		$pathToPublic = $pathToUploads."public/";

		$this->assertTrue(file_exists($pathToUploads));
		$this->assertTrue(file_exists($pathToPublic));

	}

	// test various login permutations
	// existing accounts:
	// Student --> email: dave@gmail.com, password: dave
	// TA --> email: mike@gmail.com, password: mike
	public function testLogin(){
		
		//connect to database
		$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		// make sure we have a session variable and assume we start off not logged on
		if(!isset($_SESSION)){
			$_SESSION = array();
			$_SESSION['logon'] = false;
		}

		// test login with wrong email
		$email = "dave@hotmail.com";
		$password = "dave";

		loginUser($email, $password, $dbc, true);

		$this->assertFalse($_SESSION['logon']);

		// test login with wrong password
		$email = "dave@gmail.com";
		$password = "wrong";

		loginUser($email, $password, $dbc, true);

		$this->assertFalse($_SESSION['logon']);

		// test TA ogin with wrong password
		$email = "mike@gmail.com";
		$password = "wrong";

		loginUser($email, $password, $dbc, true);

		$this->assertFalse($_SESSION['logon']);

		// test login with empty email
		$email = "";
		$password = "dave";

		loginUser($email, $password, $dbc, true);

		$this->assertFalse($_SESSION['logon']);

		// test login with empty password
		$email = "dave@gmail.com";
		$password = "";

		loginUser($email, $password, $dbc, true);

		$this->assertFalse($_SESSION['logon']);

		// test login with correct student account
		$email = "dave@gmail.com";
		$password = "dave";

		loginUser($email, $password, $dbc, true);

		$this->assertTrue($_SESSION['logon']);
		$this->assertEquals($_SESSION['name'], 'dave');

		// test login with correct TA account
		$email = "mike@gmail.com";
		$password = "mike";

		loginUser($email, $password, $dbc, true);

		$this->assertTrue($_SESSION['logon']);
		$this->assertEquals($_SESSION['name'], 'mike');
	}


	// test various student account creation permutations
	// existing associations:
	// course SOEN341 AA is already assigned ta id: 100
	function testCreateStudentAccount(){

		//connect to database
		$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		/* DEFINE OUR DUMMY (STUDENT) USER */

			$id = "209";
			$name = "dummy";
			$email = "dummy@gmail.com";
			$password = "dummy";
			$repassword = "dummy";
			$classList = array();
			$classList[] = "SOEN341 AA";
			// ta for SOEN341 AA has id=100
			$taid = 100;
			// student should be put into group 0 by default
			$pid = 0;

		/* REGISTER A DUMMY ACCOUNT WITHOUT MATCHING PASSWORDS */

			$badpass = "doesntmatch";

			// perform registration with bad password in place of $repassword param
			$result = attemptRegistration($id, $name, $email, $password, $badpass, $classList, $dbc);

			// check that we get an error message
			$this->assertEquals($result, '<h2> The passwords you entered do not match. Try again.</h2>');

		/* REGISTER A DUMMY ACCOUNT WITH INVALID ID NUMBER */

			$badid = "1";

			// perform registration with bad id in place of $id param
			$result = attemptRegistration($badid, $name, $email, $password, $repassword, $classList, $dbc);

			// check that we get an error message
			$this->assertEquals($result, '<h2> Sorry, you are not enrolled in our database! </h2>');

		/* REGISTER A DUMMY ACCOUNT WITH CORRECT INFO */

			// perform registration
			$result = attemptRegistration($id, $name, $email, $password, $repassword, $classList, $dbc);

			// check that we got a successful message
			$this->assertEquals($result, '<h2>Record created successfully!</h2>');

		/* CHECK THAT THE DUMMY ACCOUNT IS IN THE DB IN ALL THE RIGHT PLACES */

			// check that they have been added to the Student table
			$dummyStudentEntry = mysqli_query($dbc, "SELECT * FROM Student WHERE sid='$id' && name='$name' && email='$email' && password='$password'");
			$this->assertTrue(isset($dummyStudentEntry));
			$this->assertEquals(mysqli_num_rows($dummyStudentEntry), 1);

			// check that they have been added to the Project table
			$dummyProjectEntry = mysqli_query($dbc, "SELECT * FROM Project WHERE sid='$id' && ta='$taid' && pid='$pid'");
			$this->assertTrue(isset($dummyProjectEntry));
			$this->assertEquals(mysqli_num_rows($dummyProjectEntry), 1);

		/* MAKE SURE IF WE TRY TO REGISTER AGAIN IT SAYS WE ALREADY EXIST */

			// perform registration for the second time
			$result = attemptRegistration($id, $name, $email, $password, $repassword, $classList, $dbc);

			// check that we get an error message
			$this->assertEquals($result, '<h2> Sorry. This Concordia ID is already registered in the system</h2>');

		/* REMOVE THE DUMMY ACCOUNT FROM THE DB AKA CLEAN-UP */

			mysqli_query($dbc, "DELETE FROM Student WHERE sid='$id' && name='$name' && email='$email' && password='$password'");
			mysqli_query($dbc, "DELETE FROM Project WHERE sid='$id' && ta='$taid' && pid='$pid'");

	}

	// test TA account creation
	// existing associations:
	// course ENCS282 AA is already assigned ta id: 104
	function testCreateTAAccount(){

		//connect to database
		$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		/* DEFINE OUR DUMMY (TA) USER */

			$id = "104";
			$name = "dummy";
			$email = "dummy@gmail.com";
			$password = "dummy";
			$repassword = "dummy";
			$classList = array();
			$classList[] = "ENCS282 AA";

		/* REGISTER A DUMMY ACCOUNT WITH CORRECT INFO */

			// perform registration
			$result = attemptRegistration($id, $name, $email, $password, $repassword, $classList, $dbc);

			// check that we got a successful message
			$this->assertEquals($result, '<h2>Record created successfully!</h2>');

		/* CHECK THAT THE DUMMY ACCOUNT IS IN THE DB IN ALL THE RIGHT PLACES */

			// check that they have been added to the Ta table
			$dummyTAEntry = mysqli_query($dbc, "SELECT * FROM Ta WHERE ta='$id' && name='$name' && email='$email' && password='$password'");
			$this->assertTrue(isset($dummyTAEntry));
			$this->assertEquals(mysqli_num_rows($dummyTAEntry), 1);

		/* MAKE SURE IF WE TRY TO REGISTER AGAIN IT SAYS WE ALREADY EXIST */

			// perform registration for the second time
			$result = attemptRegistration($id, $name, $email, $password, $repassword, $classList, $dbc);

			// check that we get an error message
			$this->assertEquals($result, '<h2> Sorry. This Concordia ID is already registered in the system</h2>');

		/* REMOVE THE DUMMY ACCOUNT FROM THE DB AKA CLEAN-UP */

			mysqli_query($dbc, "DELETE FROM Ta WHERE ta='$id' && name='$name' && email='$email' && password='$password'");

	}
}