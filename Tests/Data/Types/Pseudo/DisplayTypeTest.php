<?php

namespace Ucc\Tests\Data\Types\Pseudo;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Pseudo\DisplayType;
use Ucc\Data\Format\Display\Display;

class DisplayTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(DisplayType::getRequirementsOptions()));
    }

    public function testIsPass()
    {
        $supplied       = array('product-id');
        $requirements   = array('fields' => array('product'));

        $this->assertTrue(DisplayType::is($supplied, $requirements));
    }

    public function testIsFail()
    {
        $supplied       = array('products_id-id');
        $requirements   = array('fields' => array('id'));

        $this->assertFalse(DisplayType::is($supplied, $requirements));
    }

    public function testCheckPass()
    {
        $supplied       = array('product-id');
        $display        = new Display;
        $display
            ->setField('product')
            ->setAlias('id');

        $expected       = array($display);
        $requirements   = array('fields' => array('product'));
        $actual         = DisplayType::check($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInternalType('array', $actual);
        $this->assertInstanceOf(get_class($display), $actual[0]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage list of fields to display constraint has not been specified for display
     */
    public function testCheckFailNoRequirementsFields()
    {
        $supplied       = array('name-firstname');
        $requirements   = array();
        $actual         = DisplayType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage value must be a list of fields
     */
    public function testCheckFail()
    {
        $supplied       = 'name-firstname';
        $requirements   = array('fields' => array('id'));
        $actual         = DisplayType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage {field}-{alias}
     */
    public function testCheckFailWrongFormat()
    {
        $supplied       = array(array());
        $requirements   = array('fields' => array('id'));
        $actual         = DisplayType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage must contain valid field names
     */
    public function testCheckFailMissingFieldPart()
    {
        $supplied       = array('-id');
        $requirements   = array('fields' => array('id'));
        $actual         = DisplayType::check($supplied, $requirements);
    }
}
