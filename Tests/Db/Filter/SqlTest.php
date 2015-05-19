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

    public function containsIncCriterionsProvider()
    {
        $containsIncValueCriterion = new Criterion;
        $containsIncValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('inc')
            ->setType('value')
            ->setValue('abc');

        $containsIncValueClause = new Clause;
        $containsIncValueClause
            ->setStatement('and `foo` LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $containsIncValueOrCriterion = new Criterion;
        $containsIncValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('inc')
            ->setType('value')
            ->setValue('abc');

        $containsIncValueOrClause = new Clause;
        $containsIncValueOrClause
            ->setStatement('or `loo` LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $containsIncFieldCriterion = new Criterion;
        $containsIncFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('inc')
            ->setType('field')
            ->setValue('abc');

        $containsIncFieldClause = new Clause;
        $containsIncFieldClause
            ->setStatement('and `bar` LIKE CONCAT("%", `abc`, "%") COLLATE utf8_bin');

        $containsIncFieldOrCriterion = new Criterion;
        $containsIncFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('inc')
            ->setType('field')
            ->setValue('loo');

        $containsIncFieldOrClause = new Clause;
        $containsIncFieldOrClause
            ->setStatement('or `bar` LIKE CONCAT("%", `loo`, "%") COLLATE utf8_bin');

        return array(
            array($containsIncValueCriterion, $containsIncValueClause),
            array($containsIncValueOrCriterion, $containsIncValueOrClause),
            array($containsIncFieldCriterion, $containsIncFieldClause),
            array($containsIncFieldOrCriterion, $containsIncFieldOrClause),
        );
    }

    public function containsNincCriterionsProvider()
    {
        $containsNincValueCriterion = new Criterion;
        $containsNincValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('ninc')
            ->setType('value')
            ->setValue('abc');

        $containsNincValueClause = new Clause;
        $containsNincValueClause
            ->setStatement('and `foo` NOT LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $containsNincValueOrCriterion = new Criterion;
        $containsNincValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('ninc')
            ->setType('value')
            ->setValue('abc');

        $containsNincValueOrClause = new Clause;
        $containsNincValueOrClause
            ->setStatement('or `loo` NOT LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $containsNincFieldCriterion = new Criterion;
        $containsNincFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('ninc')
            ->setType('field')
            ->setValue('abc');

        $containsNincFieldClause = new Clause;
        $containsNincFieldClause
            ->setStatement('and `bar` NOT LIKE CONCAT("%", `abc`, "%") COLLATE utf8_bin');

        $containsNincFieldOrCriterion = new Criterion;
        $containsNincFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('ninc')
            ->setType('field')
            ->setValue('loo');

        $containsNincFieldOrClause = new Clause;
        $containsNincFieldOrClause
            ->setStatement('or `bar` NOT LIKE CONCAT("%", `loo`, "%") COLLATE utf8_bin');

        return array(
            array($containsNincValueCriterion, $containsNincValueClause),
            array($containsNincValueOrCriterion, $containsNincValueOrClause),
            array($containsNincFieldCriterion, $containsNincFieldClause),
            array($containsNincFieldOrCriterion, $containsNincFieldOrClause),
        );
    }

    public function containsInciCriterionsProvider()
    {
        $containsInciValueCriterion = new Criterion;
        $containsInciValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('inci')
            ->setType('value')
            ->setValue('abc');

        $containsInciValueClause = new Clause;
        $containsInciValueClause
            ->setStatement('and `foo` LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $containsInciValueOrCriterion = new Criterion;
        $containsInciValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('inci')
            ->setType('value')
            ->setValue('abc');

        $containsInciValueOrClause = new Clause;
        $containsInciValueOrClause
            ->setStatement('or `loo` LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $containsInciFieldCriterion = new Criterion;
        $containsInciFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('inci')
            ->setType('field')
            ->setValue('abc');

        $containsInciFieldClause = new Clause;
        $containsInciFieldClause
            ->setStatement('and `bar` LIKE CONCAT("%", `abc`, "%") COLLATE utf8_general_ci');

        $containsInciFieldOrCriterion = new Criterion;
        $containsInciFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('inci')
            ->setType('field')
            ->setValue('loo');

        $containsInciFieldOrClause = new Clause;
        $containsInciFieldOrClause
            ->setStatement('or `bar` LIKE CONCAT("%", `loo`, "%") COLLATE utf8_general_ci');

        return array(
            array($containsInciValueCriterion, $containsInciValueClause),
            array($containsInciValueOrCriterion, $containsInciValueOrClause),
            array($containsInciFieldCriterion, $containsInciFieldClause),
            array($containsInciFieldOrCriterion, $containsInciFieldOrClause),
        );
    }

    public function containsNinciCriterionsProvider()
    {
        $containsNinciValueCriterion = new Criterion;
        $containsNinciValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('ninci')
            ->setType('value')
            ->setValue('abc');

        $containsNinciValueClause = new Clause;
        $containsNinciValueClause
            ->setStatement('and `foo` NOT LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $containsNinciValueOrCriterion = new Criterion;
        $containsNinciValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('ninci')
            ->setType('value')
            ->setValue('abc');

        $containsNinciValueOrClause = new Clause;
        $containsNinciValueOrClause
            ->setStatement('or `loo` NOT LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $containsNinciFieldCriterion = new Criterion;
        $containsNinciFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('ninci')
            ->setType('field')
            ->setValue('abc');

        $containsNinciFieldClause = new Clause;
        $containsNinciFieldClause
            ->setStatement('and `bar` NOT LIKE CONCAT("%", `abc`, "%") COLLATE utf8_general_ci');

        $containsNinciFieldOrCriterion = new Criterion;
        $containsNinciFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('ninci')
            ->setType('field')
            ->setValue('loo');

        $containsNinciFieldOrClause = new Clause;
        $containsNinciFieldOrClause
            ->setStatement('or `bar` NOT LIKE CONCAT("%", `loo`, "%") COLLATE utf8_general_ci');

        return array(
            array($containsNinciValueCriterion, $containsNinciValueClause),
            array($containsNinciValueOrCriterion, $containsNinciValueOrClause),
            array($containsNinciFieldCriterion, $containsNinciFieldClause),
            array($containsNinciFieldOrCriterion, $containsNinciFieldOrClause),
        );
    }

    public function beginsBeginsCriterionsProvider()
    {
        $beginsBeginsValueCriterion = new Criterion;
        $beginsBeginsValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('begins')
            ->setType('value')
            ->setValue('abc');

        $beginsBeginsValueClause = new Clause;
        $beginsBeginsValueClause
            ->setStatement('and `foo` LIKE CONCAT(:filter_0, "%") COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $beginsBeginsValueOrCriterion = new Criterion;
        $beginsBeginsValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('begins')
            ->setType('value')
            ->setValue('abc');

        $beginsBeginsValueOrClause = new Clause;
        $beginsBeginsValueOrClause
            ->setStatement('or `loo` LIKE CONCAT(:filter_0, "%") COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $beginsBeginsFieldCriterion = new Criterion;
        $beginsBeginsFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('begins')
            ->setType('field')
            ->setValue('abc');

        $beginsBeginsFieldClause = new Clause;
        $beginsBeginsFieldClause
            ->setStatement('and `bar` LIKE CONCAT(`abc`, "%") COLLATE utf8_bin');

        $beginsBeginsFieldOrCriterion = new Criterion;
        $beginsBeginsFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('begins')
            ->setType('field')
            ->setValue('loo');

        $beginsBeginsFieldOrClause = new Clause;
        $beginsBeginsFieldOrClause
            ->setStatement('or `bar` LIKE CONCAT(`loo`, "%") COLLATE utf8_bin');

        return array(
            array($beginsBeginsValueCriterion, $beginsBeginsValueClause),
            array($beginsBeginsValueOrCriterion, $beginsBeginsValueOrClause),
            array($beginsBeginsFieldCriterion, $beginsBeginsFieldClause),
            array($beginsBeginsFieldOrCriterion, $beginsBeginsFieldOrClause),
        );
    }

    public function beginsNbeginsCriterionsProvider()
    {
        $beginsNbeginsValueCriterion = new Criterion;
        $beginsNbeginsValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('nbegins')
            ->setType('value')
            ->setValue('abc');

        $beginsNbeginsValueClause = new Clause;
        $beginsNbeginsValueClause
            ->setStatement('and `foo` NOT LIKE CONCAT(:filter_0, "%") COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $beginsNbeginsValueOrCriterion = new Criterion;
        $beginsNbeginsValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('nbegins')
            ->setType('value')
            ->setValue('abc');

        $beginsNbeginsValueOrClause = new Clause;
        $beginsNbeginsValueOrClause
            ->setStatement('or `loo` NOT LIKE CONCAT(:filter_0, "%") COLLATE utf8_bin')
            ->setParameter('filter_0', 'abc');

        $beginsNbeginsFieldCriterion = new Criterion;
        $beginsNbeginsFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('nbegins')
            ->setType('field')
            ->setValue('abc');

        $beginsNbeginsFieldClause = new Clause;
        $beginsNbeginsFieldClause
            ->setStatement('and `bar` NOT LIKE CONCAT(`abc`, "%") COLLATE utf8_bin');

        $beginsNbeginsFieldOrCriterion = new Criterion;
        $beginsNbeginsFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('nbegins')
            ->setType('field')
            ->setValue('loo');

        $beginsNbeginsFieldOrClause = new Clause;
        $beginsNbeginsFieldOrClause
            ->setStatement('or `bar` NOT LIKE CONCAT(`loo`, "%") COLLATE utf8_bin');

        return array(
            array($beginsNbeginsValueCriterion, $beginsNbeginsValueClause),
            array($beginsNbeginsValueOrCriterion, $beginsNbeginsValueOrClause),
            array($beginsNbeginsFieldCriterion, $beginsNbeginsFieldClause),
            array($beginsNbeginsFieldOrCriterion, $beginsNbeginsFieldOrClause),
        );
    }

    public function beginsbeginsiCriterionsProvider()
    {
        $beginsbeginsiValueCriterion = new Criterion;
        $beginsbeginsiValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('beginsi')
            ->setType('value')
            ->setValue('abc');

        $beginsbeginsiValueClause = new Clause;
        $beginsbeginsiValueClause
            ->setStatement('and `foo` LIKE CONCAT(:filter_0, "%") COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $beginsbeginsiValueOrCriterion = new Criterion;
        $beginsbeginsiValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('beginsi')
            ->setType('value')
            ->setValue('abc');

        $beginsbeginsiValueOrClause = new Clause;
        $beginsbeginsiValueOrClause
            ->setStatement('or `loo` LIKE CONCAT(:filter_0, "%") COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $beginsbeginsiFieldCriterion = new Criterion;
        $beginsbeginsiFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('beginsi')
            ->setType('field')
            ->setValue('abc');

        $beginsbeginsiFieldClause = new Clause;
        $beginsbeginsiFieldClause
            ->setStatement('and `bar` LIKE CONCAT(`abc`, "%") COLLATE utf8_general_ci');

        $beginsbeginsiFieldOrCriterion = new Criterion;
        $beginsbeginsiFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('beginsi')
            ->setType('field')
            ->setValue('loo');

        $beginsbeginsiFieldOrClause = new Clause;
        $beginsbeginsiFieldOrClause
            ->setStatement('or `bar` LIKE CONCAT(`loo`, "%") COLLATE utf8_general_ci');

        return array(
            array($beginsbeginsiValueCriterion, $beginsbeginsiValueClause),
            array($beginsbeginsiValueOrCriterion, $beginsbeginsiValueOrClause),
            array($beginsbeginsiFieldCriterion, $beginsbeginsiFieldClause),
            array($beginsbeginsiFieldOrCriterion, $beginsbeginsiFieldOrClause),
        );
    }

    public function beginsNbeginsiCriterionsProvider()
    {
        $beginsNbeginsiValueCriterion = new Criterion;
        $beginsNbeginsiValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('nbeginsi')
            ->setType('value')
            ->setValue('abc');

        $beginsNbeginsiValueClause = new Clause;
        $beginsNbeginsiValueClause
            ->setStatement('and `foo` NOT LIKE CONCAT(:filter_0, "%") COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $beginsNbeginsiValueOrCriterion = new Criterion;
        $beginsNbeginsiValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('nbeginsi')
            ->setType('value')
            ->setValue('abc');

        $beginsNbeginsiValueOrClause = new Clause;
        $beginsNbeginsiValueOrClause
            ->setStatement('or `loo` NOT LIKE CONCAT(:filter_0, "%") COLLATE utf8_general_ci')
            ->setParameter('filter_0', 'abc');

        $beginsNbeginsiFieldCriterion = new Criterion;
        $beginsNbeginsiFieldCriterion
            ->setLogic('and')
            ->setKey('bar')
            ->setOperand('nbeginsi')
            ->setType('field')
            ->setValue('abc');

        $beginsNbeginsiFieldClause = new Clause;
        $beginsNbeginsiFieldClause
            ->setStatement('and `bar` NOT LIKE CONCAT(`abc`, "%") COLLATE utf8_general_ci');

        $beginsNbeginsiFieldOrCriterion = new Criterion;
        $beginsNbeginsiFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('nbeginsi')
            ->setType('field')
            ->setValue('loo');

        $beginsNbeginsiFieldOrClause = new Clause;
        $beginsNbeginsiFieldOrClause
            ->setStatement('or `bar` NOT LIKE CONCAT(`loo`, "%") COLLATE utf8_general_ci');

        return array(
            array($beginsNbeginsiValueCriterion, $beginsNbeginsiValueClause),
            array($beginsNbeginsiValueOrCriterion, $beginsNbeginsiValueOrClause),
            array($beginsNbeginsiFieldCriterion, $beginsNbeginsiFieldClause),
            array($beginsNbeginsiFieldOrCriterion, $beginsNbeginsiFieldOrClause),
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

    /**
     * @dataProvider containsIncCriterionsProvider
     */
    public function testCriterionToContainsIncPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToContains($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider containsNincCriterionsProvider
     */
    public function testCriterionToContainsNincPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToContains($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider containsInciCriterionsProvider
     */
    public function testCriterionToContainsInciPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToContains($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider containsNinciCriterionsProvider
     */
    public function testCriterionToContainsNinciPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToContains($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider beginsBeginsCriterionsProvider
     */
    public function testCriterionToBeginsBeginsPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToBegins($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider beginsNbeginsCriterionsProvider
     */
    public function testCriterionToNbeginsBeginsPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToBegins($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider beginsbeginsiCriterionsProvider
     */
    public function testCriterionToBeginsiBeginsPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToBegins($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider beginsNbeginsiCriterionsProvider
     */
    public function testCriterionToNbeginsiBeginsPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToBegins($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }
}
