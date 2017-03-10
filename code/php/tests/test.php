<?php

namespace code\php\tests;

/**
 * @covers All
 */
final class Test extends \PHPUnit_Framework_TestCase
{
    public function testTrueEqualsTrue()
    {
        $this->assertEquals(true, true);
    }
}

?>