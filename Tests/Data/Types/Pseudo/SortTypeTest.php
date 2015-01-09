<?php

namespace Ucc\Tests\Data\Types\Pseudo;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Pseudo\SortType;
use Ucc\Sortable\Sort\Sort;

class SortTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(SortType::getRequirementsOptions()));
    }

    public function testIsPass()
    {
        $supplied       = array('id-asc');
        $requirements   = array('fields' => array('id'));

        $this->assertTrue(SortType::is($supplied, $requirements));
    }

    public function testIsFail()
    {
        $supplied       = array('id-decc');
        $requirements   = array('fields' => array('id'));

        $this->assertFalse(SortType::is($supplied, $requirements));
    }

    public function testCheckPass()
    {
        $supplied       = array('name-asc');
        $sort           = new Sort;
        $sort
            ->setField('name')
            ->setDirection('asc');

        $expected       = array($sort);
        $requirements   = array('fields' => array('name'));
        $actual         = SortType::check($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInternalType('array', $actual);
        $this->assertInstanceOf('Ucc\Sortable\Sort\Sort', $actual[0]);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage allowable list of fields constraint has not been specified for a sort
     */
    public function testCheckFailNoRequirementsFields()
    {
        $supplied       = array('name-asc');
        $requirements   = array();
        $actual         = SortType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage value must be a list of sorts
     */
    public function testCheckFail()
    {
        $supplied       = 'name-asc';
        $requirements   = array('fields' => array('id'));
        $actual         = SortType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage {field}-{direction}
     */
    public function testCheckFailWrongFormat()
    {
        $supplied       = array(array());
        $requirements   = array('fields' => array('id'));
        $actual         = SortType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage and part 1 (field) must be one of
     */
    public function testCheckFailMissingSortPart()
    {
        $supplied       = array('name');
        $requirements   = array('fields' => array('id'));
        $actual         = SortType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage part 2 (direction) must be one of
     */
    public function testCheckFailWrondDirecionPart()
    {
        $supplied       = array('name-wrong');
        $requirements   = array('fields' => array('id'));
        $actual         = SortType::check($supplied, $requirements);
    }
}
