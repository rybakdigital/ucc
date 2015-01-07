<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Basic\BasicTypes;

class BasicTypeTest extends TestCase
{
    public function testCheckIntegerPass()
    {
        $expected       = "5";
        $actual         = BasicTypes::checkInteger($expected);
        $expected       = (int) $expected;

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage value must be an integer
     */
    public function testCheckIntegerFail()
    {
        $expected       = "abc";
        $actual         = BasicTypes::checkInteger($expected);
    }

    public function testCheckIntegerPassWithRequirements()
    {
        $expected       = "5";
        $requirements   = array('values' => array(1,3,5,7,9));
        $actual         = BasicTypes::checkInteger($expected, $requirements);
        $expected       = (int) $expected;

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    public function testCheckStringPass()
    {
        $expected       = "abc";
        $actual         = BasicTypes::checkString($expected);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage value must be a string
     */
    public function testCheckStringFail()
    {
        $expected       = array('abc');
        $actual         = BasicTypes::checkString($expected);
    }

    public function testCheckStringPassWithRequirements()
    {
        $expected       = "foo";
        $requirements   = array('values' => array('foo', 'bar'));
        $actual         = BasicTypes::checkString($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }
}
