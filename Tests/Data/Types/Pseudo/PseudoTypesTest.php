<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Pseudo\PseudoTypes;
use Ucc\Filter\Criterion\Criterion;

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

        $expected       = array($criterion);
        $requirements   = array('fields' => array('id'));
        $actual         = PseudoTypes::checkFilter($supplied, $requirements);

        // Compare actual and existing params
        $this->assertInternalType('array', $actual);
        $this->assertInstanceOf('Ucc\Filter\Criterion\Criterion', $actual[0]);
        $this->assertEquals($expected, $actual);
    }
}
