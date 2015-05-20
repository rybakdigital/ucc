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
            ->setStatement('AND (`foo` IS NOT NULL AND `foo` != "")');

        $boolOneCriterion = new Criterion;
        $boolOneCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('bool')
            ->setType('value')
            ->setValue(1);

        $boolOneClause = new Clause;
        $boolOneClause
            ->setStatement('AND (`foo` IS NOT NULL AND `foo` != "")');

        $boolFalseCriterion = new Criterion;
        $boolFalseCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('bool')
            ->setType('value')
            ->setValue('false');

        $boolFalseClause = new Clause;
        $boolFalseClause
            ->setStatement('AND (`foo` IS NULL OR `foo` = "")');

        $boolZeroCriterion = new Criterion;
        $boolZeroCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('bool')
            ->setType('value')
            ->setValue(0);

        $boolZeroClause = new Clause;
        $boolZeroClause
            ->setStatement('AND (`foo` IS NULL OR `foo` = "")');

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
            ->setStatement('AND `foo` = CAST(:filter_0 AS CHAR) COLLATE utf8_bin')
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
            ->setStatement('OR `loo` = CAST(:filter_0 AS CHAR) COLLATE utf8_bin')
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
            ->setStatement('AND `bar` = CAST(`abc` AS CHAR) COLLATE utf8_bin');

        $directEqFieldOrCriterion = new Criterion;
        $directEqFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('eq')
            ->setType('field')
            ->setValue('loo');

        $directEqFieldOrClause = new Clause;
        $directEqFieldOrClause
            ->setStatement('OR `bar` = CAST(`loo` AS CHAR) COLLATE utf8_bin');

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
            ->setStatement('AND `foo` != CAST(:filter_0 AS CHAR) COLLATE utf8_bin')
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
            ->setStatement('OR `loo` != CAST(:filter_0 AS CHAR) COLLATE utf8_bin')
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
            ->setStatement('AND `bar` != CAST(`abc` AS CHAR) COLLATE utf8_bin');

        $directNeFieldOrCriterion = new Criterion;
        $directNeFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('ne')
            ->setType('field')
            ->setValue('loo');

        $directNeFieldOrClause = new Clause;
        $directNeFieldOrClause
            ->setStatement('OR `bar` != CAST(`loo` AS CHAR) COLLATE utf8_bin');

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
            ->setStatement('AND `foo` = CAST(:filter_0 AS CHAR) COLLATE utf8_general_ci')
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
            ->setStatement('OR `loo` = CAST(:filter_0 AS CHAR) COLLATE utf8_general_ci')
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
            ->setStatement('AND `bar` = CAST(`abc` AS CHAR) COLLATE utf8_general_ci');

        $directEqiFieldOrCriterion = new Criterion;
        $directEqiFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('eqi')
            ->setType('field')
            ->setValue('loo');

        $directEqiFieldOrClause = new Clause;
        $directEqiFieldOrClause
            ->setStatement('OR `bar` = CAST(`loo` AS CHAR) COLLATE utf8_general_ci');

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
            ->setStatement('AND `foo` != CAST(:filter_0 AS CHAR) COLLATE utf8_general_ci')
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
            ->setStatement('OR `loo` != CAST(:filter_0 AS CHAR) COLLATE utf8_general_ci')
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
            ->setStatement('AND `bar` != CAST(`abc` AS CHAR) COLLATE utf8_general_ci');

        $directNeiFieldOrCriterion = new Criterion;
        $directNeiFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('nei')
            ->setType('field')
            ->setValue('loo');

        $directNeiFieldOrClause = new Clause;
        $directNeiFieldOrClause
            ->setStatement('OR `bar` != CAST(`loo` AS CHAR) COLLATE utf8_general_ci');

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
            ->setStatement('AND `foo` > :filter_0')
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
            ->setStatement('OR `loo` > :filter_0')
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
            ->setStatement('AND `bar` > `abc`');

        $relativeGtFieldOrCriterion = new Criterion;
        $relativeGtFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('gt')
            ->setType('field')
            ->setValue('loo');

        $relativeGtFieldOrClause = new Clause;
        $relativeGtFieldOrClause
            ->setStatement('OR `bar` > `loo`');

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
            ->setStatement('AND `foo` >= :filter_0')
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
            ->setStatement('OR `loo` >= :filter_0')
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
            ->setStatement('AND `bar` >= `abc`');

        $relativeGeFieldOrCriterion = new Criterion;
        $relativeGeFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('ge')
            ->setType('field')
            ->setValue('loo');

        $relativeGeFieldOrClause = new Clause;
        $relativeGeFieldOrClause
            ->setStatement('OR `bar` >= `loo`');

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
            ->setStatement('AND `foo` < :filter_0')
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
            ->setStatement('OR `loo` < :filter_0')
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
            ->setStatement('AND `bar` < `abc`');

        $relativeLtFieldOrCriterion = new Criterion;
        $relativeLtFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('lt')
            ->setType('field')
            ->setValue('loo');

        $relativeLtFieldOrClause = new Clause;
        $relativeLtFieldOrClause
            ->setStatement('OR `bar` < `loo`');

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
            ->setStatement('AND `foo` <= :filter_0')
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
            ->setStatement('OR `loo` <= :filter_0')
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
            ->setStatement('AND `bar` <= `abc`');

        $relativeLeFieldOrCriterion = new Criterion;
        $relativeLeFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('le')
            ->setType('field')
            ->setValue('loo');

        $relativeLeFieldOrClause = new Clause;
        $relativeLeFieldOrClause
            ->setStatement('OR `bar` <= `loo`');

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
            ->setStatement('AND `foo` LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_bin')
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
            ->setStatement('OR `loo` LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_bin')
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
            ->setStatement('AND `bar` LIKE CONCAT("%", `abc`, "%") COLLATE utf8_bin');

        $containsIncFieldOrCriterion = new Criterion;
        $containsIncFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('inc')
            ->setType('field')
            ->setValue('loo');

        $containsIncFieldOrClause = new Clause;
        $containsIncFieldOrClause
            ->setStatement('OR `bar` LIKE CONCAT("%", `loo`, "%") COLLATE utf8_bin');

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
            ->setStatement('AND `foo` NOT LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_bin')
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
            ->setStatement('OR `loo` NOT LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_bin')
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
            ->setStatement('AND `bar` NOT LIKE CONCAT("%", `abc`, "%") COLLATE utf8_bin');

        $containsNincFieldOrCriterion = new Criterion;
        $containsNincFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('ninc')
            ->setType('field')
            ->setValue('loo');

        $containsNincFieldOrClause = new Clause;
        $containsNincFieldOrClause
            ->setStatement('OR `bar` NOT LIKE CONCAT("%", `loo`, "%") COLLATE utf8_bin');

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
            ->setStatement('AND `foo` LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_general_ci')
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
            ->setStatement('OR `loo` LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_general_ci')
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
            ->setStatement('AND `bar` LIKE CONCAT("%", `abc`, "%") COLLATE utf8_general_ci');

        $containsInciFieldOrCriterion = new Criterion;
        $containsInciFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('inci')
            ->setType('field')
            ->setValue('loo');

        $containsInciFieldOrClause = new Clause;
        $containsInciFieldOrClause
            ->setStatement('OR `bar` LIKE CONCAT("%", `loo`, "%") COLLATE utf8_general_ci');

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
            ->setStatement('AND `foo` NOT LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_general_ci')
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
            ->setStatement('OR `loo` NOT LIKE CONCAT("%", :filter_0, "%") COLLATE utf8_general_ci')
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
            ->setStatement('AND `bar` NOT LIKE CONCAT("%", `abc`, "%") COLLATE utf8_general_ci');

        $containsNinciFieldOrCriterion = new Criterion;
        $containsNinciFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('ninci')
            ->setType('field')
            ->setValue('loo');

        $containsNinciFieldOrClause = new Clause;
        $containsNinciFieldOrClause
            ->setStatement('OR `bar` NOT LIKE CONCAT("%", `loo`, "%") COLLATE utf8_general_ci');

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
            ->setStatement('AND `foo` LIKE CONCAT(:filter_0, "%") COLLATE utf8_bin')
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
            ->setStatement('OR `loo` LIKE CONCAT(:filter_0, "%") COLLATE utf8_bin')
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
            ->setStatement('AND `bar` LIKE CONCAT(`abc`, "%") COLLATE utf8_bin');

        $beginsBeginsFieldOrCriterion = new Criterion;
        $beginsBeginsFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('begins')
            ->setType('field')
            ->setValue('loo');

        $beginsBeginsFieldOrClause = new Clause;
        $beginsBeginsFieldOrClause
            ->setStatement('OR `bar` LIKE CONCAT(`loo`, "%") COLLATE utf8_bin');

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
            ->setStatement('AND `foo` NOT LIKE CONCAT(:filter_0, "%") COLLATE utf8_bin')
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
            ->setStatement('OR `loo` NOT LIKE CONCAT(:filter_0, "%") COLLATE utf8_bin')
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
            ->setStatement('AND `bar` NOT LIKE CONCAT(`abc`, "%") COLLATE utf8_bin');

        $beginsNbeginsFieldOrCriterion = new Criterion;
        $beginsNbeginsFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('nbegins')
            ->setType('field')
            ->setValue('loo');

        $beginsNbeginsFieldOrClause = new Clause;
        $beginsNbeginsFieldOrClause
            ->setStatement('OR `bar` NOT LIKE CONCAT(`loo`, "%") COLLATE utf8_bin');

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
            ->setStatement('AND `foo` LIKE CONCAT(:filter_0, "%") COLLATE utf8_general_ci')
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
            ->setStatement('OR `loo` LIKE CONCAT(:filter_0, "%") COLLATE utf8_general_ci')
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
            ->setStatement('AND `bar` LIKE CONCAT(`abc`, "%") COLLATE utf8_general_ci');

        $beginsbeginsiFieldOrCriterion = new Criterion;
        $beginsbeginsiFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('beginsi')
            ->setType('field')
            ->setValue('loo');

        $beginsbeginsiFieldOrClause = new Clause;
        $beginsbeginsiFieldOrClause
            ->setStatement('OR `bar` LIKE CONCAT(`loo`, "%") COLLATE utf8_general_ci');

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
            ->setStatement('AND `foo` NOT LIKE CONCAT(:filter_0, "%") COLLATE utf8_general_ci')
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
            ->setStatement('OR `loo` NOT LIKE CONCAT(:filter_0, "%") COLLATE utf8_general_ci')
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
            ->setStatement('AND `bar` NOT LIKE CONCAT(`abc`, "%") COLLATE utf8_general_ci');

        $beginsNbeginsiFieldOrCriterion = new Criterion;
        $beginsNbeginsiFieldOrCriterion
            ->setLogic('or')
            ->setKey('bar')
            ->setOperand('nbeginsi')
            ->setType('field')
            ->setValue('loo');

        $beginsNbeginsiFieldOrClause = new Clause;
        $beginsNbeginsiFieldOrClause
            ->setStatement('OR `bar` NOT LIKE CONCAT(`loo`, "%") COLLATE utf8_general_ci');

        return array(
            array($beginsNbeginsiValueCriterion, $beginsNbeginsiValueClause),
            array($beginsNbeginsiValueOrCriterion, $beginsNbeginsiValueOrClause),
            array($beginsNbeginsiFieldCriterion, $beginsNbeginsiFieldClause),
            array($beginsNbeginsiFieldOrCriterion, $beginsNbeginsiFieldOrClause),
        );
    }

    public function regexpCriterionsProvider()
    {
        $regexValueCriterion = new Criterion;
        $regexValueCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('re')
            ->setType('value')
            ->setValue('\d+');

        $regexValueClause = new Clause;
        $regexValueClause
            ->setStatement('AND `foo` REGEXP :filter_0')
            ->setParameter('filter_0', '\d+');

        $regexValueOrCriterion = new Criterion;
        $regexValueOrCriterion
            ->setLogic('or')
            ->setKey('loo')
            ->setOperand('re')
            ->setType('value')
            ->setValue('\d+');

        $regexValueOrClause = new Clause;
        $regexValueOrClause
            ->setStatement('OR `loo` REGEXP :filter_0')
            ->setParameter('filter_0', '\d+');

        $regexFieldCriterion = new Criterion;
        $regexFieldCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('re')
            ->setType('field')
            ->setValue('loo');

        $regexFieldClause = new Clause;
        $regexFieldClause
            ->setStatement('AND `foo` REGEXP `loo`');

        return array(
            array($regexValueCriterion, $regexValueClause),
            array($regexValueOrCriterion, $regexValueOrClause),
            array($regexFieldCriterion, $regexFieldClause),
        );
    }

    public function inInCriterionsProvider()
    {
        $inInValueAndCriterion = new Criterion;
        $inInValueAndCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('in')
            ->setType('value')
            ->setValue('abc,def,xyz,123');

        $inInValueAndClause = new Clause;
        $inInValueAndClause
            ->setStatement('AND `foo` IN (:filter_0_0 COLLATE utf8_bin, :filter_0_1 COLLATE utf8_bin, :filter_0_2 COLLATE utf8_bin, :filter_0_3 COLLATE utf8_bin)')
            ->setParameters(array(
                    'filter_0_0' => 'abc',
                    'filter_0_1' => 'def',
                    'filter_0_2' => 'xyz',
                    'filter_0_3' => '123',
                ));

        $inInValueOrCriterion = new Criterion;
        $inInValueOrCriterion
            ->setLogic('or')
            ->setKey('foo')
            ->setOperand('in')
            ->setType('value')
            ->setValue('abc,def,xyz,123');

        $inInValueOrClause = new Clause;
        $inInValueOrClause
            ->setStatement('OR `foo` IN (:filter_0_0 COLLATE utf8_bin, :filter_0_1 COLLATE utf8_bin, :filter_0_2 COLLATE utf8_bin, :filter_0_3 COLLATE utf8_bin)')
            ->setParameters(array(
                    'filter_0_0' => 'abc',
                    'filter_0_1' => 'def',
                    'filter_0_2' => 'xyz',
                    'filter_0_3' => '123',
                ));

        $inInTypeAndCriterion = new Criterion;
        $inInTypeAndCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('in')
            ->setType('field')
            ->setValue('bar,loo,foo');

        $inInTypeAndClause = new Clause;
        $inInTypeAndClause
            ->setStatement('AND `foo` IN (`bar` COLLATE utf8_bin, `loo` COLLATE utf8_bin, `foo` COLLATE utf8_bin)');

        $inInTypeOrCriterion = new Criterion;
        $inInTypeOrCriterion
            ->setLogic('or')
            ->setKey('foo')
            ->setOperand('in')
            ->setType('field')
            ->setValue('bar,loo,foo');

        $inInTypeOrClause = new Clause;
        $inInTypeOrClause
            ->setStatement('OR `foo` IN (`bar` COLLATE utf8_bin, `loo` COLLATE utf8_bin, `foo` COLLATE utf8_bin)');

        return array(
            array($inInValueAndCriterion, $inInValueAndClause),
            array($inInValueOrCriterion, $inInValueOrClause),
            array($inInTypeAndCriterion, $inInTypeAndClause),
            array($inInTypeOrCriterion, $inInTypeOrClause),
        );
    }

    public function inNinCriterionsProvider()
    {
        $inNinValueAndCriterion = new Criterion;
        $inNinValueAndCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('nin')
            ->setType('value')
            ->setValue('abc,def,xyz,123');

        $inNinValueAndClause = new Clause;
        $inNinValueAndClause
            ->setStatement('AND `foo` NOT IN (:filter_0_0 COLLATE utf8_bin, :filter_0_1 COLLATE utf8_bin, :filter_0_2 COLLATE utf8_bin, :filter_0_3 COLLATE utf8_bin)')
            ->setParameters(array(
                    'filter_0_0' => 'abc',
                    'filter_0_1' => 'def',
                    'filter_0_2' => 'xyz',
                    'filter_0_3' => '123',
                ));

        $inNinValueOrCriterion = new Criterion;
        $inNinValueOrCriterion
            ->setLogic('or')
            ->setKey('foo')
            ->setOperand('nin')
            ->setType('value')
            ->setValue('abc,def,xyz,123');

        $inNinValueOrClause = new Clause;
        $inNinValueOrClause
            ->setStatement('OR `foo` NOT IN (:filter_0_0 COLLATE utf8_bin, :filter_0_1 COLLATE utf8_bin, :filter_0_2 COLLATE utf8_bin, :filter_0_3 COLLATE utf8_bin)')
            ->setParameters(array(
                    'filter_0_0' => 'abc',
                    'filter_0_1' => 'def',
                    'filter_0_2' => 'xyz',
                    'filter_0_3' => '123',
                ));

        $inNinTypeAndCriterion = new Criterion;
        $inNinTypeAndCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('nin')
            ->setType('field')
            ->setValue('bar,loo,foo');

        $inNinTypeAndClause = new Clause;
        $inNinTypeAndClause
            ->setStatement('AND `foo` NOT IN (`bar` COLLATE utf8_bin, `loo` COLLATE utf8_bin, `foo` COLLATE utf8_bin)');

        $inNinTypeOrCriterion = new Criterion;
        $inNinTypeOrCriterion
            ->setLogic('or')
            ->setKey('foo')
            ->setOperand('nin')
            ->setType('field')
            ->setValue('bar,loo,foo');

        $inNinTypeOrClause = new Clause;
        $inNinTypeOrClause
            ->setStatement('OR `foo` NOT IN (`bar` COLLATE utf8_bin, `loo` COLLATE utf8_bin, `foo` COLLATE utf8_bin)');

        return array(
            array($inNinValueAndCriterion, $inNinValueAndClause),
            array($inNinValueOrCriterion, $inNinValueOrClause),
            array($inNinTypeAndCriterion, $inNinTypeAndClause),
            array($inNinTypeOrCriterion, $inNinTypeOrClause),
        );
    }

    public function inIniCriterionsProvider()
    {
        $inIniValueAndCriterion = new Criterion;
        $inIniValueAndCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('ini')
            ->setType('value')
            ->setValue('abc,def,xyz,123');

        $inIniValueAndClause = new Clause;
        $inIniValueAndClause
            ->setStatement('AND `foo` IN (:filter_0_0 COLLATE utf8_general_ci, :filter_0_1 COLLATE utf8_general_ci, :filter_0_2 COLLATE utf8_general_ci, :filter_0_3 COLLATE utf8_general_ci)')
            ->setParameters(array(
                    'filter_0_0' => 'abc',
                    'filter_0_1' => 'def',
                    'filter_0_2' => 'xyz',
                    'filter_0_3' => '123',
                ));

        $inIniValueOrCriterion = new Criterion;
        $inIniValueOrCriterion
            ->setLogic('or')
            ->setKey('foo')
            ->setOperand('ini')
            ->setType('value')
            ->setValue('abc,def,xyz,123');

        $inIniValueOrClause = new Clause;
        $inIniValueOrClause
            ->setStatement('OR `foo` IN (:filter_0_0 COLLATE utf8_general_ci, :filter_0_1 COLLATE utf8_general_ci, :filter_0_2 COLLATE utf8_general_ci, :filter_0_3 COLLATE utf8_general_ci)')
            ->setParameters(array(
                    'filter_0_0' => 'abc',
                    'filter_0_1' => 'def',
                    'filter_0_2' => 'xyz',
                    'filter_0_3' => '123',
                ));

        $inIniTypeAndCriterion = new Criterion;
        $inIniTypeAndCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('ini')
            ->setType('field')
            ->setValue('bar,loo,foo');

        $inIniTypeAndClause = new Clause;
        $inIniTypeAndClause
            ->setStatement('AND `foo` IN (`bar` COLLATE utf8_general_ci, `loo` COLLATE utf8_general_ci, `foo` COLLATE utf8_general_ci)');

        $inIniTypeOrCriterion = new Criterion;
        $inIniTypeOrCriterion
            ->setLogic('or')
            ->setKey('foo')
            ->setOperand('ini')
            ->setType('field')
            ->setValue('bar,loo,foo');

        $inIniTypeOrClause = new Clause;
        $inIniTypeOrClause
            ->setStatement('OR `foo` IN (`bar` COLLATE utf8_general_ci, `loo` COLLATE utf8_general_ci, `foo` COLLATE utf8_general_ci)');

        return array(
            array($inIniValueAndCriterion, $inIniValueAndClause),
            array($inIniValueOrCriterion, $inIniValueOrClause),
            array($inIniTypeAndCriterion, $inIniTypeAndClause),
            array($inIniTypeOrCriterion, $inIniTypeOrClause),
        );
    }

    public function inNiniCriterionsProvider()
    {
        $inNiniValueAndCriterion = new Criterion;
        $inNiniValueAndCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('nini')
            ->setType('value')
            ->setValue('abc,def,xyz,123');

        $inNiniValueAndClause = new Clause;
        $inNiniValueAndClause
            ->setStatement('AND `foo` NOT IN (:filter_0_0 COLLATE utf8_general_ci, :filter_0_1 COLLATE utf8_general_ci, :filter_0_2 COLLATE utf8_general_ci, :filter_0_3 COLLATE utf8_general_ci)')
            ->setParameters(array(
                    'filter_0_0' => 'abc',
                    'filter_0_1' => 'def',
                    'filter_0_2' => 'xyz',
                    'filter_0_3' => '123',
                ));

        $inNiniValueOrCriterion = new Criterion;
        $inNiniValueOrCriterion
            ->setLogic('or')
            ->setKey('foo')
            ->setOperand('nini')
            ->setType('value')
            ->setValue('abc,def,xyz,123');

        $inNiniValueOrClause = new Clause;
        $inNiniValueOrClause
            ->setStatement('OR `foo` NOT IN (:filter_0_0 COLLATE utf8_general_ci, :filter_0_1 COLLATE utf8_general_ci, :filter_0_2 COLLATE utf8_general_ci, :filter_0_3 COLLATE utf8_general_ci)')
            ->setParameters(array(
                    'filter_0_0' => 'abc',
                    'filter_0_1' => 'def',
                    'filter_0_2' => 'xyz',
                    'filter_0_3' => '123',
                ));

        $inNiniTypeAndCriterion = new Criterion;
        $inNiniTypeAndCriterion
            ->setLogic('and')
            ->setKey('foo')
            ->setOperand('nini')
            ->setType('field')
            ->setValue('bar,loo,foo');

        $inNiniTypeAndClause = new Clause;
        $inNiniTypeAndClause
            ->setStatement('AND `foo` NOT IN (`bar` COLLATE utf8_general_ci, `loo` COLLATE utf8_general_ci, `foo` COLLATE utf8_general_ci)');

        $inNiniTypeOrCriterion = new Criterion;
        $inNiniTypeOrCriterion
            ->setLogic('or')
            ->setKey('foo')
            ->setOperand('nini')
            ->setType('field')
            ->setValue('bar,loo,foo');

        $inNiniTypeOrClause = new Clause;
        $inNiniTypeOrClause
            ->setStatement('OR `foo` NOT IN (`bar` COLLATE utf8_general_ci, `loo` COLLATE utf8_general_ci, `foo` COLLATE utf8_general_ci)');

        return array(
            array($inNiniValueAndCriterion, $inNiniValueAndClause),
            array($inNiniValueOrCriterion, $inNiniValueOrClause),
            array($inNiniTypeAndCriterion, $inNiniTypeAndClause),
            array($inNiniTypeOrCriterion, $inNiniTypeOrClause),
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

    /**
     * @dataProvider regexpCriterionsProvider
     */
    public function testCriterionToRegexpPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToRegex($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider inInCriterionsProvider
     */
    public function testCriterionToInInPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToIn($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider inNinCriterionsProvider
     */
    public function testCriterionToInNinPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToIn($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider inIniCriterionsProvider
     */
    public function testCriterionToInIniPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToIn($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    /**
     * @dataProvider inNiniCriterionsProvider
     */
    public function testCriterionToInNiniPass($criterion, $expected)
    {
        $sqlClause = Sql::criterionToIn($criterion);

        $this->assertInstanceOf('Ucc\Data\Filter\Clause\Clause', $sqlClause);
        $this->assertEquals($expected, $sqlClause);
    }

    public function safeFieldNameProvider()
    {
        $data = array();

        $field      = 'test';
        $fieldMap   = array();
        $expected   = '`test`';
        $data[] = array($field, $fieldMap, $expected);

        $field      = 'test';
        $fieldMap   = array('test0' => 'tbl1', 'test' => 'tbl1', 'test2' => 'tbl2');
        $expected   = '`tbl1`.`test`';
        $data[] = array($field, $fieldMap, $expected);

        $field      = 'test3';
        $fieldMap   = array('test0' => 'tbl1', 'test' => 'tbl1', 'test2' => 'tbl2', 'test3' => 'having');
        $expected   = '`test3`';
        $data[] = array($field, $fieldMap, $expected);

        $field      = 'test5';
        $fieldMap   = array('test0' => 'tbl1', 'test' => 'tbl1', 'test2' => 'tbl2', 'test3' => 'having', '*' => 'tbl4');
        $expected   = '`tbl4`.`test5`';
        $data[] = array($field, $fieldMap, $expected);

        return $data;
    }

    /**
     * @dataProvider safeFieldNameProvider
     */
    public function testgetSafeFieldName($field, $fieldMap, $expected)
    {
        $result = Sql::getSafeFieldName($field, $fieldMap);

        $this->assertSame($expected, $result);
    }

    public function escapeProvider()
    {
        $data = array();

        $string     = 1;
        $expected   = false;
        $data[] = array($string, $expected);

        $string     = '';
        $expected   = '';
        $data[] = array($string, $expected);

        $string     = 'regular string';
        $expected   = 'regular string';
        $data[] = array($string, $expected);

        $string     = '`quoted string`';
        $expected   = '`quoted string`';
        $data[] = array($string, $expected);

        $string     = "escape \\ character";
        $expected   = "escape \\\\ character";
        $data[] = array($string, $expected);

        $string     = "null \x00 character";
        $expected   = "null \\0 character";
        $data[] = array($string, $expected);

        $string     = "null \0 character";
        $expected   = "null \\0 character";
        $data[] = array($string, $expected);

        $string     = "line \n break";
        $expected   = "line \\n break";
        $data[] = array($string, $expected);

        $string     = "carriage \r return";
        $expected   = "carriage \\r return";
        $data[] = array($string, $expected);

        $string     = "DOS \r\n line break";
        $expected   = "DOS \\r\\n line break";
        $data[] = array($string, $expected);

        $string     = "'single quotes'";
        $expected   = "\\'single quotes\\'";
        $data[] = array($string, $expected);

        $string     = '"double quotes"';
        $expected   = '\\"double quotes\\"';
        $data[] = array($string, $expected);

        $string     = "\x1a question mark";
        $expected   = "\\Z question mark";
        $data[] = array($string, $expected);

        $string     = "multiple % wildcard";
        $expected   = "multiple % wildcard";
        $data[] = array($string, $expected);

        $string     = "single _ wildcard";
        $expected   = "single _ wildcard";
        $data[] = array($string, $expected);

        return $data;
    }

    /**
     * @dataProvider escapeProvider
     */
    public function testEscape($string, $expected)
    {
        $result = Sql::escape($string);
        $this->assertSame($expected, $result);
    }

    public function quoteProvider()
    {
        $data = array();

        $string     = 1;
        $expected   = false;
        $data[]     = array($string, $expected);

        $string     = 'string';
        $expected   = '`string`';
        $data[]     = array($string, $expected);

        $string     = '`quoted string`';
        $expected   = '`quoted string`';
        $data[]     = array($string, $expected);

        $string     = '`multi` `quoted` `string`';
        $expected   = '`multi quoted string`';
        $data[]     = array($string, $expected);

        return $data;
    }

    /**
     * @dataProvider quoteProvider
     */
    public function testQuote($string, $expected)
    {
        $result = Sql::quote($string);
        $this->assertSame($expected, $result);
    }

    public function safeTaleNameProviderProvider()
    {
        $data = array();

        $field      = 1;
        $fieldMap   = array();
        $expected   = false;
        $data[]     = array($field, $fieldMap, $expected);

        $field      = 'test';
        $fieldMap   = array();
        $expected   = '';
        $data[]     = array($field, $fieldMap, $expected);

        $field      = 'test0';
        $fieldMap   = array('test0' => 'tbl1', 'test' => 'tbl1', 'test2' => 'tbl2', 'test3' => 'having', '*' => 'tbl4');
        $expected   = '`tbl1`';
        $data[]     = array($field, $fieldMap, $expected);

        return $data;
    }

    /**
     * @dataProvider safeTaleNameProviderProvider
     */
    public function testGetSafeTableName($field, $fieldMap, $expected)
    {
        $result = Sql::getSafeTableName($field, $fieldMap);
        $this->assertSame($expected, $result);
    }
}
