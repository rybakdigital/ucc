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

    public function validEmailProvider()
    {
        return array(
            array('jane.doe@example.com'),
            array('jane.doe21@example.co.uk'),
            array('jane.doe.21@example.com'),
            array('jane-doe.21@example.net'),
            array('jane.doe.21.savy.and.sassy@hotmail.com'),
        );
    }

    public function invalidEmailProvider()
    {
        return array(
            array('jane.doeexample.com'),
            array('jane.doe21.example.com'),
        );
    }

    /**
     * @dataProvider    validEmailProvider
     */
    public function testCheckPass($email)
    {
        $this->assertEquals(BasicTypes::checkEmail($email), $email);
    }

    /**
     * @dataProvider    invalidEmailProvider
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     */
    public function testCheckFail($email)
    {
        $this->assertEquals(BasicTypes::checkEmail($email), $email);
    }

    public function validBooleanProvider()
    {
        return array(
            array(true, true),
            array("true", true),
            array("TRUE", true),
            array(1, true),
            array(false, false),
            array("false", false),
            array(0, false),
            array("0", false),
        );
    }

    /**
     * @dataProvider    validBooleanProvider
     */
    public function testCheckBooleanPass($boolean, $expected)
    {
        $this->assertEquals(BasicTypes::checkBoolean($boolean), $expected);
    }
}
