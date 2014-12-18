<?php

namespace Ucc\Tests\Filter;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Filter\Criterion\Criterion;

class CriterionTest extends TestCase
{
    public function testGetLogic()
    {
        $criterion = new Criterion();
        $this->assertSame(Criterion::CRITERION_LOGIC_UNION, $criterion->logic());
    }

    public function testSetLogic()
    {
        $criterion = new Criterion();
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setLogic(Criterion::CRITERION_LOGIC_INTERSCTION));
        $this->assertSame(Criterion::CRITERION_LOGIC_INTERSCTION, $criterion->logic());

        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setLogic('OR'));
        $this->assertSame(Criterion::CRITERION_LOGIC_UNION, $criterion->logic());
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testSetLogicFail()
    {
        $criterion = new Criterion();
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setLogic('abc'));
    }

    public function testSetKey()
    {
        $criterion  = new Criterion();
        $expected   = 'email';
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setKey($expected));
        $this->assertSame($expected, $criterion->key());
    }

    public function testSetOperand()
    {
        $criterion  = new Criterion();
        $expected   = 'eq';
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setOperand($expected));
        $this->assertSame($expected, $criterion->op());
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testSetOperandFail()
    {
        $criterion  = new Criterion();
        $expected   = 'foo';
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setOperand($expected));
    }

    public function testSetType()
    {
        $criterion  = new Criterion();
        $expected   = 'value';
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setType($expected));
        $this->assertSame($expected, $criterion->type());
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testSetTypeFail()
    {
        $criterion  = new Criterion();
        $expected   = 'foo';
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setType($expected));
    }

    public function testSetValue()
    {
        $criterion  = new Criterion();
        $expected   = 123;
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $criterion->setvalue($expected));
        $this->assertSame($expected, $criterion->value());
    }
}
