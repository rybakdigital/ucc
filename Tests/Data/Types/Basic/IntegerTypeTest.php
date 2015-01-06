<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Basic\IntegerType;

class IntegerTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $integerType = new IntegerType();
        $this->assertTrue(is_array(IntegerType::getRequirementsOptions()));
    }

    public function testCheckPassInteger()
    {
        $integerType    = new IntegerType();
        $expected       = 3;
        $actual         = IntegerType::check($expected);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    public function testCheckPassNumerical()
    {
        $integerType    = new IntegerType();
        $expected       = "5";
        $actual         = IntegerType::check($expected);
        $expected       = (int) $expected;

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\InvalidDataTypeException
     * @expectedExceptionMessage value must be an integer
     */
    public function testCheckIntegerFail()
    {
        $integerType    = new IntegerType();
        $expected       = 'abc';
        $actual         = IntegerType::check($expected);
    }

    public function testCheckPassIntegerWithMinRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 3;
        $requirements   = array('min' => 2);
        $actual         = IntegerType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\InvalidDataTypeException
     * @expectedExceptionMessage value must be greater than or equal to
     */
    public function testCheckFailIntegerWithMinRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 3;
        $requirements   = array('min' => 4);
        $actual         = IntegerType::check($expected, $requirements);
    }

    public function testCheckPassIntegerWithMinAndMaxRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 3;
        $requirements   = array('min' => 2, 'max' => 3);
        $actual         = IntegerType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\InvalidDataTypeException
     * @expectedExceptionMessage and greater than or equal
     */
    public function testCheckFailIntegerWithmaxAndMinRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 7;
        $requirements   = array('min' => 3, 'max' => 5);
        $actual         = IntegerType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\InvalidDataTypeException
     * @expectedExceptionMessage and less than or equal to
     */
    public function testCheckFailIntegerWithMinAndMaxRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 2;
        $requirements   = array('min' => 3, 'max' => 5);
        $actual         = IntegerType::check($expected, $requirements);
    }

    public function testCheckPassIntegerWithMaxRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 3;
        $requirements   = array('max' => 7);
        $actual         = IntegerType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\InvalidDataTypeException
     * @expectedExceptionMessage value must be less than or equal to
     */
    public function testCheckFailIntegerWithMaxRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 10;
        $requirements   = array('max' => 7);
        $actual         = IntegerType::check($expected, $requirements);
    }

    public function testCheckPassIntegerWithValuesRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 3;
        $requirements   = array('values' => array(1,3,5,7,9));
        $actual         = IntegerType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\InvalidDataTypeException
     * @expectedExceptionMessage value must be one of
     */
    public function testCheckFailIntegerWithValuesRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 2;
        $requirements   = array('values' => array(1,3,5,7,9));
        $actual         = IntegerType::check($expected, $requirements);
    }

    public function testCheckPassIntegerWithOddRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 3;
        $requirements   = array('odd' => true);
        $actual         = IntegerType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\InvalidDataTypeException
     * @expectedExceptionMessage value must be an odd number
     */
    public function testCheckFailIntegerWithOddRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 4;
        $requirements   = array('odd' => true);
        $actual         = IntegerType::check($expected, $requirements);
    }

    public function testCheckPassIntegerWithEvenRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 4;
        $requirements   = array('even' => true);
        $actual         = IntegerType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\InvalidDataTypeException
     * @expectedExceptionMessage value must be an even number
     */
    public function testCheckFailIntegerWithEvenRequirements()
    {
        $integerType    = new IntegerType();
        $expected       = 5;
        $requirements   = array('even' => true);
        $actual         = IntegerType::check($expected, $requirements);
    }
}
