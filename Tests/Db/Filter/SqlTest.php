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

    public function directEqCriterionsProvider()
    {
        $directEqValueCriterion = new Criterion;
        $directEqValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('eq')
            ->setType('value')
            ->setValue('abc');

        $directEqValueClause = new Clause;
        $directEqValueClause
            ->setStatement('and `foo` = CAST(:filter_0 AS CHAR) COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $directEqValueOrCriterion = new Criterion;
        $directEqValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('eq')
            ->setType('value')
            ->setValue('abc');

        $directEqValueOrClause = new Clause;
        $directEqValueOrClause
            ->setStatement('or `loo` = CAST(:filter_0 AS CHAR) COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $directEqFieldCriterion = new Criterion;
        $directEqFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('eq')
            ->setType('field')
            ->setValue('abc');

        $directEqFieldClause = new Clause;
        $directEqFieldClause
            ->setStatement('and `bar` = CAST(`abc` AS CHAR) COLLATE utf8_bin');

        $directEqFieldOrCriterion = new Criterion;
        $directEqFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('eq')
            ->setType('field')
            ->setValue('loo');

        $directEqFieldOrClause = new Clause;
        $directEqFieldOrClause
            ->setStatement('or `bar` = CAST(`loo` AS CHAR) COLLATE utf8_bin');

        return array(
            array($directEqValueCriterion, $directEqValueClause),
            array($directEqValueOrCriterion, $directEqValueOrClause),
            array($directEqFieldCriterion, $directEqFieldClause),
            array($directEqFieldOrCriterion, $directEqFieldOrClause),
        );
    }

    public function directNeCriterionsProvider()
    {
        $directNeValueCriterion = new Criterion;
        $directNeValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('ne')
            ->setType('value')
            ->setValue('abc');

        $directNeValueClause = new Clause;
        $directNeValueClause
            ->setStatement('and `foo` != CAST(:filter_0 AS CHAR) COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $directNeValueOrCriterion = new Criterion;
        $directNeValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('ne')
            ->setType('value')
            ->setValue('abc');

        $directNeValueOrClause = new Clause;
        $directNeValueOrClause
            ->setStatement('or `loo` != CAST(:filter_0 AS CHAR) COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $directNeFieldCriterion = new Criterion;
        $directNeFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('ne')
            ->setType('field')
            ->setValue('abc');

        $directNeFieldClause = new Clause;
        $directNeFieldClause
            ->setStatement('and `bar` != CAST(`abc` AS CHAR) COLLATE utf8_bin');

        $directNeFieldOrCriterion = new Criterion;
        $directNeFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('ne')
            ->setType('field')
            ->setValue('loo');

        $directNeFieldOrClause = new Clause;
        $directNeFieldOrClause
            ->setStatement('or `bar` != CAST(`loo` AS CHAR) COLLATE utf8_bin');

        return array(
            array($directNeValueCriterion, $directNeValueClause),
            array($directNeValueOrCriterion, $directNeValueOrClause),
            array($directNeFieldCriterion, $directNeFieldClause),
            array($directNeFieldOrCriterion, $directNeFieldOrClause),
        );
    }

    public function directEqiCriterionsProvider()
    {
        $directEqiValueCriterion = new Criterion;
        $directEqiValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('eqi')
            ->setType('value')
            ->setValue('abc');

        $directEqiValueClause = new Clause;
        $directEqiValueClause
            ->setStatement('and `foo` = CAST(:filter_0 AS CHAR) COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $directEqiValueOrCriterion = new Criterion;
        $directEqiValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('eqi')
            ->setType('value')
            ->setValue('abc');

        $directEqiValueOrClause = new Clause;
        $directEqiValueOrClause
            ->setStatement('or `loo` = CAST(:filter_0 AS CHAR) COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $directEqiFieldCriterion = new Criterion;
        $directEqiFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('eqi')
            ->setType('field')
            ->setValue('abc');

        $directEqiFieldClause = new Clause;
        $directEqiFieldClause
            ->setStatement('and `bar` = CAST(`abc` AS CHAR) COLLATE utf8_general_ci');

        $directEqiFieldOrCriterion = new Criterion;
        $directEqiFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('eqi')
            ->setType('field')
            ->setValue('loo');

        $directEqiFieldOrClause = new Clause;
        $directEqiFieldOrClause
            ->setStatement('or `bar` = CAST(`loo` AS CHAR) COLLATE utf8_general_ci');

        return array(
            array($directEqiValueCriterion, $directEqiValueClause),
            array($directEqiValueOrCriterion, $directEqiValueOrClause),
            array($directEqiFieldCriterion, $directEqiFieldClause),
            array($directEqiFieldOrCriterion, $directEqiFieldOrClause),
        );
    }

    public function directNeiCriterionsProvider()
    {
        $directNeiValueCriterion = new Criterion;
        $directNeiValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('nei')
            ->setType('value')
            ->setValue('abc');

        $directNeiValueClause = new Clause;
        $directNeiValueClause
            ->setStatement('and `foo` != CAST(:filter_0 AS CHAR) COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $directNeiValueOrCriterion = new Criterion;
        $directNeiValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('nei')
            ->setType('value')
            ->setValue('abc');

        $directNeiValueOrClause = new Clause;
        $directNeiValueOrClause
            ->setStatement('or `loo` != CAST(:filter_0 AS CHAR) COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $directNeiFieldCriterion = new Criterion;
        $directNeiFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('nei')
            ->setType('field')
            ->setValue('abc');

        $directNeiFieldClause = new Clause;
        $directNeiFieldClause
            ->setStatement('and `bar` != CAST(`abc` AS CHAR) COLLATE utf8_general_ci');

        $directNeiFieldOrCriterion = new Criterion;
        $directNeiFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('nei')
            ->setType('field')
            ->setValue('loo');

        $directNeiFieldOrClause = new Clause;
        $directNeiFieldOrClause
            ->setStatement('or `bar` != CAST(`loo` AS CHAR) COLLATE utf8_general_ci');

        return array(
            array($directNeiValueCriterion, $directNeiValueClause),
            array($directNeiValueOrCriterion, $directNeiValueOrClause),
            array($directNeiFieldCriterion, $directNeiFieldClause),
            array($directNeiFieldOrCriterion, $directNeiFieldOrClause),
        );
    }

    public function relativeGtCriterionsProvider()
    {
        $relativeGtValueCriterion = new Criterion;
        $relativeGtValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('gt')
            ->setType('value')
            ->setValue('abc');

        $relativeGtValueClause = new Clause;
        $relativeGtValueClause
            ->setStatement('and `foo` > :filter_0')
            ->setParameter('filter_0', 'abc');

        $relativeGtValueOrCriterion = new Criterion;
        $relativeGtValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('gt')
            ->setType('value')
            ->setValue('abc');

        $relativeGtValueOrClause = new Clause;
        $relativeGtValueOrClause
            ->setStatement('or `loo` > :filter_0')
            ->setParameter('filter_0', 'abc');

        $relativeGtFieldCriterion = new Criterion;
        $relativeGtFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('gt')
            ->setType('field')
            ->setValue('abc');

        $relativeGtFieldClause = new Clause;
        $relativeGtFieldClause
            ->setStatement('and `bar` > `abc`');

        $relativeGtFieldOrCriterion = new Criterion;
        $relativeGtFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('gt')
            ->setType('field')
            ->setValue('loo');

        $relativeGtFieldOrClause = new Clause;
        $relativeGtFieldOrClause
            ->setStatement('or `bar` > `loo`');

        return array(
            array($relativeGtValueCriterion, $relativeGtValueClause),
            array($relativeGtValueOrCriterion, $relativeGtValueOrClause),
            array($relativeGtFieldCriterion, $relativeGtFieldClause),
            array($relativeGtFieldOrCriterion, $relativeGtFieldOrClause),
        );
    }

    public function relativeGeCriterionsProvider()
    {
        $relativeGeValueCriterion = new Criterion;
        $relativeGeValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('ge')
            ->setType('value')
            ->setValue('abc');

        $relativeGeValueClause = new Clause;
        $relativeGeValueClause
            ->setStatement('and `foo` >= :filter_0')
            ->setParameter('filter_0', 'abc');

        $relativeGeValueOrCriterion = new Criterion;
        $relativeGeValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('ge')
            ->setType('value')
            ->setValue('abc');

        $relativeGeValueOrClause = new Clause;
        $relativeGeValueOrClause
            ->setStatement('or `loo` >= :filter_0')
            ->setParameter('filter_0', 'abc');

        $relativeGeFieldCriterion = new Criterion;
        $relativeGeFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('ge')
            ->setType('field')
            ->setValue('abc');

        $relativeGeFieldClause = new Clause;
        $relativeGeFieldClause
            ->setStatement('and `bar` >= `abc`');

        $relativeGeFieldOrCriterion = new Criterion;
        $relativeGeFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('ge')
            ->setType('field')
            ->setValue('loo');

        $relativeGeFieldOrClause = new Clause;
        $relativeGeFieldOrClause
            ->setStatement('or `bar` >= `loo`');

        return array(
            array($relativeGeValueCriterion, $relativeGeValueClause),
            array($relativeGeValueOrCriterion, $relativeGeValueOrClause),
            array($relativeGeFieldCriterion, $relativeGeFieldClause),
            array($relativeGeFieldOrCriterion, $relativeGeFieldOrClause),
        );
    }

    public function relativeLtCriterionsProvider()
    {
        $relativeLtValueCriterion = new Criterion;
        $relativeLtValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('lt')
            ->setType('value')
            ->setValue('abc');

        $relativeLtValueClause = new Clause;
        $relativeLtValueClause
            ->setStatement('and `foo` < :filter_0')
            ->setParameter('filter_0', 'abc');

        $relativeLtValueOrCriterion = new Criterion;
        $relativeLtValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('lt')
            ->setType('value')
            ->setValue('abc');

        $relativeLtValueOrClause = new Clause;
        $relativeLtValueOrClause
            ->setStatement('or `loo` < :filter_0')
            ->setParameter('filter_0', 'abc');

        $relativeLtFieldCriterion = new Criterion;
        $relativeLtFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('lt')
            ->setType('field')
            ->setValue('abc');

        $relativeLtFieldClause = new Clause;
        $relativeLtFieldClause
            ->setStatement('and `bar` < `abc`');

        $relativeLtFieldOrCriterion = new Criterion;
        $relativeLtFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('lt')
            ->setType('field')
            ->setValue('loo');

        $relativeLtFieldOrClause = new Clause;
        $relativeLtFieldOrClause
            ->setStatement('or `bar` < `loo`');

        return array(
            array($relativeLtValueCriterion, $relativeLtValueClause),
            array($relativeLtValueOrCriterion, $relativeLtValueOrClause),
            array($relativeLtFieldCriterion, $relativeLtFieldClause),
            array($relativeLtFieldOrCriterion, $relativeLtFieldOrClause),
        );
    }

    public function relativeLeCriterionsProvider()
    {
        $relativeLeValueCriterion = new Criterion;
        $relativeLeValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('le')
            ->setType('value')
            ->setValue('abc');

        $relativeLeValueClause = new Clause;
        $relativeLeValueClause
            ->setStatement('and `foo` <= :filter_0')
            ->setParameter('filter_0', 'abc');

        $relativeLeValueOrCriterion = new Criterion;
        $relativeLeValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('le')
            ->setType('value')
            ->setValue('abc');

        $relativeLeValueOrClause = new Clause;
        $relativeLeValueOrClause
            ->setStatement('or `loo` <= :filter_0')
            ->setParameter('filter_0', 'abc');

        $relativeLeFieldCriterion = new Criterion;
        $relativeLeFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('le')
            ->setType('field')
            ->setValue('abc');

        $relativeLeFieldClause = new Clause;
        $relativeLeFieldClause
            ->setStatement('and `bar` <= `abc`');

        $relativeLeFieldOrCriterion = new Criterion;
        $relativeLeFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('le')
            ->setType('field')
            ->setValue('loo');

        $relativeLeFieldOrClause = new Clause;
        $relativeLeFieldOrClause
            ->setStatement('or `bar` <= `loo`');

        return array(
            array($relativeLeValueCriterion, $relativeLeValueClause),
            array($relativeLeValueOrCriterion, $relativeLeValueOrClause),
            array($relativeLeFieldCriterion, $relativeLeFieldClause),
            array($relativeLeFieldOrCriterion, $relativeLeFieldOrClause),
        );
    }

    /**
     * @dataProvider boolCriterionsProvider
     */
    public function testCriterionToBoolPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToBool($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider directEqCriterionsProvider
     */
    public function testCriterionToDirectEqPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToDirectClause($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider directNeCriterionsProvider
     */
    public function testCriterionToDirectNePass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToDirectClause($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider directEqiCriterionsProvider
     */
    public function testCriterionToDirectEqiPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToDirectClause($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider directNeiCriterionsProvider
     */
    public function testCriterionToDirectNeiPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToDirectClause($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider relativeGtCriterionsProvider
     */
    public function testCriterionToRelativeGtPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToRelative($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider relativeGeCriterionsProvider
     */
    public function testCriterionToRelativeGePass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToRelative($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider relativeLtCriterionsProvider
     */
    public function testCriterionToRelativeLtPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToRelative($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider relativeLeCriterionsProvider
     */
    public function testCriterionToLelativeGePass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToRelative($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }
}
