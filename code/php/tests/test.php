<?php

namespace code\php\tests;
	
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
}