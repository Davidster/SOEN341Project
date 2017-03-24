<?php

require './vendor/autoload.php';
use Guzzle\Http\Client;
	
/**
 * This file contains the unit tests for our project
 * 
 * @covers All
 */
final class Test extends \PHPUnit_Framework_TestCase
{

	public function testDBCExists(){
		require_once './code/sql_connect.php';
		$this->assertEquals(isset($dbc), true);
	}

	public function testGET(){

		//require './vendor/autoload.php'

		// Create a client and provide a base URL
		$client = new Client('http://localhost:80');

		$request = $client->get('/code/php/index/home.php');
		echo $request->getUrl();
		// >>> https://api.github.com/user

		// You must send a request in order for the transfer to occur
		$response = $request->send();

		echo $response->getBody();
		// >>> {"type":"User", ...

		echo $response->getHeader('Content-Length');
		// >>> 792

		// >>> User
		$this->assertEquals(true, true);
	}
}