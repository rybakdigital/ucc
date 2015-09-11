<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Pseudo\PseudoTypes;
use Ucc\Data\Filter\Criterion\Criterion;
use Ucc\Data\Sortable\Sort\Sort;
use Ucc\Data\Format\Display\Display;
use Ucc\Data\Format\Format\Format;
use Ucc\Data\Filter\Filter;

class PseudoTypesTest extends TestCase
{
    public function testCheckFilterPass()
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
        $actual         = PseudoTypes::checkFilter($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInstanceOf(get_class($filter), $actual);
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFiltersPass()
    {
        $supplied       = array(array('and-id-eq-value-12'), array('and-id-eq-value-12'));
        $criterion      = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('id')
            ->setOperand('eq')
            ->setType('value')
            ->setValue('12');

        $filterA = new Filter;
        $filterA->addCriterion($criterion);

        $filterB = new Filter;
        $filterB->addCriterion($criterion);

        $expected       = array($filterA, $filterB);
        $requirements   = array('fields' => array('id'));
        $actual         = PseudoTypes::checkFilters($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInternalType('array', $actual);
        $this->assertInstanceOf(get_class($filterA), $actual[0]);
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFiltersWithOneFilterPass()
    {
        $supplied       = array('and-id-eq-value-12');
        $criterion      = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('id')
            ->setOperand('eq')
            ->setType('value')
            ->setValue('12');

        $filterA = new Filter;
        $filterA->addCriterion($criterion);

        $expected       = array($filterA);
        $requirements   = array('fields' => array('id'));
        $actual         = PseudoTypes::checkFilters($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInternalType('array', $actual);
        $this->assertInstanceOf(get_class($filterA), $actual[0]);
        $this->assertEquals($expected, $actual);
    }

    public function testCheckSortPass()
    {
        $supplied       = array('name-asc');
        $sort           = new Sort;
        $sort
            ->setField('name')
            ->setDirection('asc');

        $expected       = array($sort);
        $requirements   = array('fields' => array('name'));
        $actual         = PseudoTypes::checkSort($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInternalType('array', $actual);
        $this->assertInstanceOf(get_class($sort), $actual[0]);
        $this->assertEquals($expected, $actual);
    }

    public function testCheckDisplayPass()
    {
        $supplied       = array('product-id');
        $display        = new Display;
        $display
            ->setField('product')
            ->setAlias('id');

        $expected       = array($display);
        $requirements   = array('fields' => array('product'));
        $actual         = PseudoTypes::checkDisplay($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInternalType('array', $actual);
        $this->assertInstanceOf(get_class($display), $actual[0]);
        $this->assertEquals($expected, $actual);
    }

    public function testCheckFormatPass()
    {
        $supplied       = 'json';
        $format         = new Format;
        $format
            ->setFormat($supplied);

        $expected       = $format;
        $requirements   = array();
        $actual         = PseudoTypes::checkFormat($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInstanceOf(get_class($format), $actual);
        $this->assertEquals($expected, $actual);
    }
}
