<?php

namespace Ucc\Tests\Data\Filter;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Filter\Criterion\Criterion;

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
        $this->assertInstanceOf(get_class($criterion), $criterion->setLogic(Criterion::CRITERION_LOGIC_INTERSCTION));
        $this->assertSame(Criterion::CRITERION_LOGIC_INTERSCTION, $criterion->logic());

        $this->assertInstanceOf('Ucc\Data\Filter\Criterion\Criterion', $criterion->setLogic('OR'));
        $this->assertSame(Criterion::CRITERION_LOGIC_UNION, $criterion->logic());
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testSetLogicFail()
    {
        $criterion = new Criterion();
        $this->assertInstanceOf(get_class($criterion), $criterion->setLogic('abc'));
    }

    public function testSetKey()
    {
        $criterion  = new Criterion();
        $expected   = 'email';
        $this->assertInstanceOf(get_class($criterion), $criterion->setKey($expected));
        $this->assertSame($expected, $criterion->key());
    }

    public function testSetOperand()
    {
        $criterion  = new Criterion();
        $expected   = 'eq';
        $this->assertInstanceOf(get_class($criterion), $criterion->setOperand($expected));
        $this->assertSame($expected, $criterion->op());
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testSetOperandFail()
    {
        $criterion  = new Criterion();
        $expected   = 'foo';
        $this->assertInstanceOf(get_class($criterion), $criterion->setOperand($expected));
    }

    public function testSetType()
    {
        $criterion  = new Criterion();
        $expected   = 'value';
        $this->assertInstanceOf(get_class($criterion), $criterion->setType($expected));
        $this->assertSame($expected, $criterion->type());
    }

    /**
     * @expectedException     InvalidArgumentException
     */
    public function testSetTypeFail()
    {
        $criterion  = new Criterion();
        $expected   = 'foo';
        $this->assertInstanceOf(get_class($criterion), $criterion->setType($expected));
    }

    public function testSetValue()
    {
        $criterion  = new Criterion();
        $expected   = 123;
        $this->assertInstanceOf(get_class($criterion), $criterion->setValue($expected));
        $this->assertSame($expected, $criterion->value());
    }

    public function testToString()
    {
        $criterion  = new Criterion();
        $expected   = 'and-make-eq-value-Audi';

        $criterion
            ->setLogic('and')
            ->setKey('make')
            ->setOperand('eq')
            ->setType('value')
            ->setValue('Audi');

        $this->assertSame($expected, $criterion->toString());
    }

    public function testToStringFail()
    {
        $criterion  = new Criterion();
        $expected   = 'and-make-eq-value-Audi';

        $criterion
            ->setLogic('and')
            ->setKey('make')
            ->setOperand('eq')
            ->setType('value')
            ->setValue('audi');

        $this->assertNotSame($expected, $criterion->toString());
    }
}
