<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Basic\BooleanType;

class BooleanTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(BooleanType::getRequirementsOptions()));
    }

    public function booleanPassProvider()
    {
        return array(
            array(true, true),
            array(false, false),
        );
    }

    /**
     * @dataProvider   booleanPassProvider
     */
    public function testCheckBooleanPass($value, $expected)
    {
        $this->assertEquals($expected, BooleanType::check($value));
    }

    public function booleanFailProvider()
    {
        return array(
            array(true, false),
            array(false, true),
        );
    }

    /**
     * @dataProvider   booleanFailProvider
     */
    public function testCheckBooleanFail($value, $expected)
    {
        $this->assertNotEquals($expected, BooleanType::check($value));
    }

    public function integerPassProvider()
    {
        return array(
            array(1, true),
            array(0, false),
        );
    }

    /**
     * @dataProvider   integerPassProvider
     */
    public function testCheckIntegerPass($value, $expected)
    {
        $this->assertEquals($expected, BooleanType::check($value));
    }

    public function integerFailProvider()
    {
        return array(
            array(1, false),
            array(0, true),
        );
    }

    /**
     * @dataProvider   integerFailProvider
     */
    public function testCheckIntegerFail($value, $expected)
    {
        $this->assertNotEquals($expected, BooleanType::check($value));
    }

    public function stringPassProvider()
    {
        return array(
            array("true", true),
            array("True", true),
            array("1", true),
            array("false", false),
            array("FALSE", false),
            array("0", false),
        );
    }

    /**
     * @dataProvider   stringPassProvider
     */
    public function testCheckStringPass($value, $expected)
    {
        $this->assertEquals($expected, BooleanType::check($value));
    }

    public function stringFailProvider()
    {
        return array(
            array("true", false),
            array("True", false),
            array("1", false),
            array("false", true),
            array("FALSE", true),
            array("0", true),
        );
    }

    /**
     * @dataProvider   stringFailProvider
     */
    public function testCheckStringFail($value, $expected)
    {
        $this->assertNotEquals($expected, BooleanType::check($value));
    }

    public function randomProvider()
    {
        return array(
            array("5", false),
            array(5, false),
            array(array(), true),
            array("String", true),
        );
    }

    /**
     * @dataProvider   randomProvider
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     */
    public function testCheckRandomValueFail($value, $expected)
    {
        $this->assertEquals($expected, BooleanType::check($value));
    }

    public function isPassProvider()
    {
        return array(
            array(true, true),
            array(false, true),
            array(0, true),
            array(1, true),
            array("True", true),
            array("FALSE", true),
            array("0", true),
            array("1", true),
            array("10", false),
            array("No", false),
            array("Truth", false),
            array("", false),
            array(null, false),
        );
    }

    /**
     * @dataProvider   isPassProvider
     */
    public function testIsPass($value, $expected)
    {
        $this->assertEquals($expected, BooleanType::is($value));
    }
}
