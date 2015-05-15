<?php

namespace Ucc\Tests\Data\Filter\Criterion;

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

    public function testGetDirectOperands()
    {
        $criterion  = new Criterion();
        $this->assertTrue(is_array($criterion->getDirectOperands()));
        $this->assertNotEmpty($criterion->getDirectOperands());

        $expected = array(
            Criterion::CRITERION_OP_EQ,
            Criterion::CRITERION_OP_EQI,
            Criterion::CRITERION_OP_NE,
            Criterion::CRITERION_OP_NEI
        );

        $this->assertEquals($expected, $criterion->getDirectOperands());
    }

    public function testGetRelativeOperands()
    {
        $criterion  = new Criterion();
        $this->assertTrue(is_array($criterion->getRelativeOperands()));
        $this->assertNotEmpty($criterion->getRelativeOperands());

        $expected = array(
            Criterion::CRITERION_OP_LT,
            Criterion::CRITERION_OP_GT,
            Criterion::CRITERION_OP_GE,
            Criterion::CRITERION_OP_LE
        );

        $this->assertEquals($expected, $criterion->getRelativeOperands());
    }

    public function testGetContainsOperands()
    {
        $criterion  = new Criterion();
        $this->assertTrue(is_array($criterion->getContainsOperands()));
        $this->assertNotEmpty($criterion->getContainsOperands());

        $expected = array(
            Criterion::CRITERION_OP_INC,
            Criterion::CRITERION_OP_INCI,
            Criterion::CRITERION_OP_NINC,
            Criterion::CRITERION_OP_NINCI
        );

        $this->assertEquals($expected, $criterion->getContainsOperands());
    }

    public function testGetBeginsOperands()
    {
        $criterion  = new Criterion();
        $this->assertTrue(is_array($criterion->getBeginsOperands()));
        $this->assertNotEmpty($criterion->getBeginsOperands());

        $expected = array(
            Criterion::CRITERION_OP_BEGINS,
            Criterion::CRITERION_OP_BEGINSI,
            Criterion::CRITERION_OP_NBEGINS,
            Criterion::CRITERION_OP_NBEGINSI
        );

        $this->assertEquals($expected, $criterion->getBeginsOperands());
    }

    public function testGetInOperands()
    {
        $criterion  = new Criterion();
        $this->assertTrue(is_array($criterion->getInOperands()));
        $this->assertNotEmpty($criterion->getInOperands());

        $expected = array(
            Criterion::CRITERION_OP_IN,
            Criterion::CRITERION_OP_INI,
            Criterion::CRITERION_OP_NIN,
            Criterion::CRITERION_OP_NINI
        );

        $this->assertEquals($expected, $criterion->getInOperands());
    }

    public function testGetRegexOperands()
    {
        $criterion  = new Criterion();
        $this->assertTrue(is_array($criterion->getRegexOperands()));
        $this->assertNotEmpty($criterion->getRegexOperands());

        $expected = array(
            Criterion::CRITERION_OP_RE
        );

        $this->assertEquals($expected, $criterion->getRegexOperands());
    }
}
