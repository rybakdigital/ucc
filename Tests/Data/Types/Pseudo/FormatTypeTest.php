<?php

namespace Ucc\Tests\Data\Types\Pseudo;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Pseudo\FormatType;
use Ucc\Data\Format\Format\Format;

class FormatTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(FormatType::getRequirementsOptions()));
    }

    public function testIsPass()
    {
        $supplied       = 'json';

        $this->assertTrue(FormatType::is($supplied));
    }

    public function testIsFail()
    {
        $supplied       = array('json-array');
        $this->assertFalse(FormatType::is($supplied));
    }

    public function testCheckPass()
    {
        $supplied       = 'json';
        $format         = new Format;
        $format->setFormat('json');

        $expected       = $format;
        $actual         = FormatType::check($supplied);

        // Compare actual and existing params
        $this->assertInstanceOf(get_class($format), $actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage value must be one of:
     */
    public function testCheckFail()
    {
        $supplied       = 'wrongFormat';
        $actual         = FormatType::check($supplied);
    }

    public function testCheckPassWithRequirements()
    {
        $supplied       = 'jsonarray';
        $requirements   = array('values' => array('jsonarray'));
        $format         = new Format;
        $format->setFormat('jsonarray');

        $expected       = $format;
        $actual         = FormatType::check($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInstanceOf(get_class($format), $actual);
        $this->assertEquals($expected, $actual);
    }
}
