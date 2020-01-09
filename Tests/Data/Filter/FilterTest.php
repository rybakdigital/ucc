<?php

namespace Ucc\Tests\Data\Filter;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Filter\Filter;
use Ucc\Data\Filter\Criterion\Criterion;

class FilterTest extends TestCase
{
    public function testGetLogic()
    {
        $filter = new Filter();
        $this->assertSame(Filter::FILTER_LOGIC_INTERSCTION, $filter->logic());
    }

    public function testSetLogic()
    {
        $filter = new Filter();

        $this->assertInstanceOf('Ucc\Data\Filter\Filter', $filter->setLogic('OR'));
        $this->assertSame(Filter::FILTER_LOGIC_UNION, $filter->logic());
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testSetLogicFail()
    {
        $filter = new Filter();
        $this->assertInstanceOf(get_class($filter), $filter->setLogic('abc'));
    }

    public function testGetCriterions()
    {
        $filter = new Filter();
        $this->assertTrue(is_array($filter->getCriterions()));
    }

    public function testSetCriterions()
    {
        $criterions = array(new Criterion, new Criterion);
        $filter     = new Filter();
        $this->assertInstanceOf(get_class($filter), $filter->setCriterions($criterions));
        $this->assertTrue(is_array($filter->getCriterions()));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testSetCriterionsFail()
    {
        $criterions = array('abc', 'def', 1);
        $filter = new Filter();
        $this->assertInstanceOf(get_class($filter), $filter->setCriterions($criterions));
    }

    public function removeCriterionProvider()
    {
        $criterion1 = new Criterion();
        $criterion2 = new Criterion();
        $criterion3 = new Criterion();
        $criterion4 = new Criterion();

        return array(
            array(array($criterion1, $criterion2), $criterion1),
        );
    }

    /**
     * @dataProvider removeCriterionProvider
     */
    public function testRemoveCriterion($criterions, $toBeRemoved)
    {
        $filter     = new Filter();
        $this->assertInstanceOf(get_class($filter), $filter->setCriterions($criterions));
        $this->assertInstanceOf(get_class($filter), $filter->removeCriterion($toBeRemoved));
        var_dump($filter->getCriterions());
        $this->assertFalse(in_array($toBeRemoved, $filter->getCriterions()));
    }
}
