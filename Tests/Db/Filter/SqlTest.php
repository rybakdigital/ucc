<?php

namespace Ucc\Tests\Db\Filter;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Filter\Criterion\Criterion;
use Ucc\Data\Filter\Clause\Clause;
use Ucc\Db\Filter\Sql;

class SqlTest extends TestCase
{
    public function boolCriterionsProvider()
    {
        $boolTrueCriterion = new Criterion;
        $boolTrueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('bool')
            ->setType('value')
            ->setValue('true');

        $boolTrueClause = new Clause;
        $boolTrueClause
            ->setStatement('(`foo` IS NOT NULL AND `foo` != "")');

        $boolOneCriterion = new Criterion;
        $boolOneCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('bool')
            ->setType('value')
            ->setValue(1);

        $boolOneClause = new Clause;
        $boolOneClause
            ->setStatement('(`foo` IS NOT NULL AND `foo` != "")');

        $boolFalseCriterion = new Criterion;
        $boolFalseCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('bool')
            ->setType('value')
            ->setValue('false');

        $boolFalseClause = new Clause;
        $boolFalseClause
            ->setStatement('(`foo` IS NULL OR `foo` = "")');

        $boolZeroCriterion = new Criterion;
        $boolZeroCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('bool')
            ->setType('value')
            ->setValue(0);

        $boolZeroClause = new Clause;
        $boolZeroClause
            ->setStatement('(`foo` IS NULL OR `foo` = "")');

        return array(
            array($boolTrueCriterion, $boolTrueClause),
            array($boolOneCriterion, $boolOneClause),
            array($boolFalseCriterion, $boolFalseClause),
            array($boolZeroCriterion, $boolZeroClause),
        );
    }

    /**
     * @dataProvider boolCriterionsProvider
     */
    public function testCriterionToBoolPass($criterion, $expected)
    {
        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', Sql::criterionToBool($criterion));
        $sqlClause = Sql::criterionToBool($criterion);

        $this->assertEquals($expected, $sqlClause);
    }
}
