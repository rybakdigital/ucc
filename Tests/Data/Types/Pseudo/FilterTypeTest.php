<?php

namespace Ucc\Tests\Data\Types\Pseudo;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Pseudo\FilterType;
use Ucc\Data\Filter\Criterion\Criterion;
use Ucc\Data\Filter\Filter;

class FilterTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(FilterType::getRequirementsOptions()));
    }

    public function testCheckPass()
    {
        $supplied       = array('and-id-eq-value-12');
        $criterion      = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('id')
            ->setOperand('eq')
            ->setType('value')
            ->setValue('12');

        $filter = new Filter;
        $filter->addCriterion($criterion);

        $expected       = $filter;
        $requirements   = array('fields' => array('id'));
        $actual         = FilterType::check($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInstanceOf(get_class($filter), $actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage allowable list of fields constraint has not been specified for a filter
     */
    public function testCheckFailNoRequirementsFields()
    {
        $supplied       = array('and-id-eq-value-12');
        $requirements   = array();
        $actual         = FilterType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     * @expectedExceptionMessage value must be a list of filters
     */
    public function testCheckFail()
    {
        $supplied       = 'and-id-eq-value-12';
        $requirements   = array('fields' => array('id'));
        $actual         = FilterType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage {logic}-{field}-{operand}-{type}-{value}
     */
    public function testCheckFailWrongFormat()
    {
        $supplied       = array(array());
        $requirements   = array('fields' => array('id'));
        $actual         = FilterType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage and part 1 (logic) must be one of
     */
    public function testCheckFailMissingFilterPart()
    {
        $supplied       = array('and-id-eq');
        $requirements   = array('fields' => array('id'));
        $actual         = FilterType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage and part 1 (logic) must be one of
     */
    public function testCheckFailWrongLogic()
    {
        $supplied       = array('aa-id-eq-value-12');
        $requirements   = array('fields' => array('id'));
        $actual         = FilterType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage part 2 (field) must be one of
     */
    public function testCheckFailWrongField()
    {
        $supplied       = array('and-id-eq-value-12');
        $requirements   = array('fields' => array('key'));
        $actual         = FilterType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage and part 1 (logic) must be one of
     */
    public function testCheckFailWrongOperand()
    {
        $supplied       = array('and-id-eqqq-value-12');
        $requirements   = array('fields' => array('id'));
        $actual         = FilterType::check($supplied, $requirements);
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage part 4 (type) must be one of (field or value)
     */
    public function testCheckFailWrongType()
    {
        $supplied       = array('and-id-eq-wrongType-12');
        $requirements   = array('fields' => array('id'));
        $actual         = FilterType::check($supplied, $requirements);
    }

    public function testIsPass()
    {
        $supplied       = array('and-id-eq-value-12');
        $requirements   = array('fields' => array('id'));

        $this->assertTrue(FilterType::is($supplied, $requirements));
    }

    public function testIsFail()
    {
        $supplied       = array('aa-id-eq-wrongType-12');
        $requirements   = array('fields' => array('id'));

        $this->assertFalse(FilterType::is($supplied, $requirements));
    }

    /**
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     * @expectedExceptionMessage and part 5 (value) must be one of
     */
    public function testFilterToCriterionFailWrongBooleanType()
    {
        $filter = 'and-id-bool-value-nottrue';
        FilterType::criteriaToCriterion($filter);
    }

    public function testFilterToCriterionPassBooleanType()
    {
        $filter = 'and-id-bool-value-true';
        $this->assertInstanceOf('Ucc\Data\Filter\Criterion\Criterion', FilterType::criteriaToCriterion($filter));

        $filter = 'and-id-bool-value-false';
        $this->assertInstanceOf('Ucc\Data\Filter\Criterion\Criterion', FilterType::criteriaToCriterion($filter));
    }
}
