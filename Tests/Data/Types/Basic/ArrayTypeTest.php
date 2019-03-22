<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Basic\ArrayType;

class ArrayTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(ArrayType::getRequirementsOptions()));
    }

    public function arrayProvider()
    {
        return array(
            array([]),
            array(array()),
            array(array(1, 2 ,3)),
        );
    }

    /**
     * @dataProvider   arrayProvider
     */
    public function testCheckPass($value)
    {
        $this->assertEquals($value, ArrayType::check($value));
    }

    /**
     * @dataProvider    arrayProvider
     */
    public function testIsPass($array)
    {
        $this->assertTrue(ArrayType::is($array));
    }

    public function invalidArrayProvider()
    {
        return array(
            array(1),
            array("abc"),
            array(new \StdClass),
            array(true),
        );
    }

    /**
     * @dataProvider    invalidArrayProvider
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     */
    public function testCheckFail($notArray)
    {
        $this->assertEquals(ArrayType::check($notArray), $notArray);
    }

    /**
     * @dataProvider    invalidArrayProvider
     */
    public function testIsFail($notArray)
    {
        $this->assertFalse(ArrayType::is($notArray));
    }
}
