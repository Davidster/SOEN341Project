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
}