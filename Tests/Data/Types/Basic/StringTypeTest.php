<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Basic\StringType;

class StringTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(StringType::getRequirementsOptions()));
    }

    public function testCheckPass()
    {
        $expected       = 'abc';
        $actual         = StringType::check($expected);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage value must be a string
     */
    public function testCheckFail()
    {
        $expected       = array('abc');
        $actual         = StringType::check($expected);
    }

    public function testCheckWithValueRequirementsPass()
    {
        $expected       = 'foo';
        $requirements   = array('values' => array('abc', 'foo'));
        $actual         = StringType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage value must be one of:
     */
    public function testCheckWithValueRequirementsFail()
    {
        $expected       = 'bar';
        $requirements   = array('values' => array('abc', 'foo'));
        $actual         = StringType::check($expected, $requirements);
    }

    public function testCheckWithMinAndMaxRequirementsPass()
    {
        $expected       = 'foo';
        $requirements   = array('min' => 2, 'max' => 5);
        $actual         = StringType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage value length is outside of allowed range
     */
    public function testCheckWithMinAndMaxRequirementsFail()
    {
        $expected       = 'foo';
        $requirements   = array('min' => 4, 'max' => 5);
        $actual         = StringType::check($expected, $requirements);
    }

    public function testCheckWithMinRequirementsPass()
    {
        $expected       = 'foo';
        $requirements   = array('min' => 2);
        $actual         = StringType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage value length must be greater than or
     */
    public function testCheckWithMinRequirementsFail()
    {
        $expected       = 'foo';
        $requirements   = array('min' => 5);
        $actual         = StringType::check($expected, $requirements);
    }

    public function testCheckWithMaxRequirementsPass()
    {
        $expected       = 'foo';
        $requirements   = array('max' => 5);
        $actual         = StringType::check($expected, $requirements);

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage value length must be less than or
     */
    public function testCheckWithMaxRequirementsFail()
    {
        $expected       = 'foo';
        $requirements   = array('max' => 2);
        $actual         = StringType::check($expected, $requirements);
    }

    public function testIsPass()
    {
        $expected       = 'abc';

        $this->assertTrue(StringType::is($expected));
    }

    public function testIsFail()
    {
        $expected       = array('abc');

        $this->assertFalse(StringType::is($expected));
    }
}
