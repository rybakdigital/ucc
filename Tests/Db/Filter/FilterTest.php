<?php

namespace Ucc\Tests\Db\Filter;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Db\Filter\Filter as Db_Filter;
use Ucc\Data\Filter\Criterion\Criterion;

class FilterTest extends TestCase
{
    /**
     * @expectedException     Ucc\Exception\Data\InvalidDataTypeException
     */
    public function testCriteriaToDQLNonArrayCriteria()
    {
        $criteria = 'abc';

        Db_Filter::criteriaToSql($criteria);
    }

    /**
     * @expectedException     Ucc\Exception\Data\InvalidDataTypeException
     */
    public function testCriteriaToDQLArrayCriterionInteger()
    {
        $criteria = 1;

        Db_Filter::criteriaToSql($criteria);
    }

    /**
     * @expectedException     Ucc\Exception\Data\InvalidDataTypeException
     */
    public function testCriteriaToDQLArrayCriterionStringWrongFormat()
    {
        $criteria = 'abc';

        Db_Filter::criteriaToSql($criteria);
    }

    public function testCriterionOperandToDirectMethod()
    {
        $criterion = new Criterion;

        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        $eqKeys = Criterion::getDirectOperands();

        foreach ($eqKeys as $key => $operand) {
            $criterion->setOperand($operand);

            // Test method
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertEquals('criterionToDirect', $method);
        }
    }

    public function testCriterionOperandToDirectMethodFail()
    {
        // Create generic Criterion
        $criterion = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        // Get all available operands
        $criterionOperands = Criterion::$criterionOperands;

        // Remove operands resulting in `criterionToDirect` method
        $eqKeys = Criterion::getDirectOperands();

        foreach ($eqKeys as $key) {
            $parentKey = array_search($key, $criterionOperands);

            if ($parentKey !== false) {
                unset($criterionOperands[$parentKey]);
            }
        }

        // Loop through remaining operands and check if they NOT resolve to `criterionToDirect` method
        foreach ($criterionOperands as $key => $operand) {
            $criterion
                ->setOperand($operand);

            // Test each operand fails
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertNotEquals('criterionToDirect', $method);
        }
    }

    public function testCriterionOperandToBoolMethod()
    {
        $criterion = new Criterion;

        $criterion
            ->setLogic('and')
            ->setOperand('bool')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        $method = Db_Filter::criterionOperandToMethod($criterion);

        $this->assertEquals('criterionToBool', $method);
    }

    public function testCriterionOperandToBoolMethodFail()
    {
        // Create generic Criterion
        $criterion = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        // Get all available operands
        $criterionOperands = Criterion::$criterionOperands;

        // Remove operands resulting in `criterionToBool` method
        $boolKeys = Criterion::getBoolOperands();

        foreach ($boolKeys as $key) {
            $parentKey = array_search($key, $criterionOperands);

            if ($parentKey !== false) {
                unset($criterionOperands[$parentKey]);
            }
        }

        // Loop through remaining operands and check if they NOT resolve to `criterionToBool` method
        foreach ($criterionOperands as $key => $operand) {
            $criterion
                ->setOperand($operand);

            // Test each operand fails
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertNotEquals('criterionToBool', $method);
        }
    }

    public function testCriterionOperandToRelatveMethod()
    {
        $criterion = new Criterion;

        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        $relativeKeys = Criterion::getRelativeOperands();

        foreach ($relativeKeys as $key => $operand) {
            $criterion->setOperand($operand);

            // Test method
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertEquals('criterionToRelative', $method);
        }
    }

    public function testCriterionOperandToRelativeMethodFail()
    {
        // Create generic Criterion
        $criterion = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        // Get all available operands
        $criterionOperands = Criterion::$criterionOperands;

        // Remove operands resulting in `criterionToRelative` method
        $relativeKeys = Criterion::getRelativeOperands();

        foreach ($relativeKeys as $key) {
            $parentKey = array_search($key, $criterionOperands);

            if ($parentKey !== false) {
                unset($criterionOperands[$parentKey]);
            }
        }

        // Loop through remaining operands and check if they NOT resolve to `criterionToRelative` method
        foreach ($criterionOperands as $key => $operand) {
            $criterion
                ->setOperand($operand);

            // Test each operand fails
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertNotEquals('criterionToRelative', $method);
        }
    }

    public function testCriterionOperandToContainsMethod()
    {
        $criterion = new Criterion;

        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        $relativeKeys = Criterion::getContainsOperands();

        foreach ($relativeKeys as $key => $operand) {
            $criterion->setOperand($operand);

            // Test method
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertEquals('criterionToContains', $method);
        }
    }

    public function testCriterionOperandToContainsMethodFail()
    {
        // Create generic Criterion
        $criterion = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        // Get all available operands
        $criterionOperands = Criterion::$criterionOperands;

        // Remove operands resulting in `criterionToContains` method
        $relativeKeys = Criterion::getContainsOperands();

        foreach ($relativeKeys as $key) {
            $parentKey = array_search($key, $criterionOperands);

            if ($parentKey !== false) {
                unset($criterionOperands[$parentKey]);
            }
        }

        // Loop through remaining operands and check if they NOT resolve to `criterionToContains` method
        foreach ($criterionOperands as $key => $operand) {
            $criterion
                ->setOperand($operand);

            // Test each operand fails
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertNotEquals('criterionToContains', $method);
        }
    }

    public function testCriterionOperandToBeginsMethod()
    {
        $criterion = new Criterion;

        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        $relativeKeys = Criterion::getBeginsOperands();

        foreach ($relativeKeys as $key => $operand) {
            $criterion->setOperand($operand);

            // Test method
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertEquals('criterionToBegins', $method);
        }
    }

    public function testCriterionOperandToBeginsMethodFail()
    {
        // Create generic Criterion
        $criterion = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        // Get all available operands
        $criterionOperands = Criterion::$criterionOperands;

        // Remove operands resulting in `criterionToBegins` method
        $relativeKeys = Criterion::getBeginsOperands();

        foreach ($relativeKeys as $key) {
            $parentKey = array_search($key, $criterionOperands);

            if ($parentKey !== false) {
                unset($criterionOperands[$parentKey]);
            }
        }

        // Loop through remaining operands and check if they NOT resolve to `criterionToBegins` method
        foreach ($criterionOperands as $key => $operand) {
            $criterion
                ->setOperand($operand);

            // Test each operand fails
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertNotEquals('criterionToBegins', $method);
        }
    }

    public function testCriterionOperandToInMethod()
    {
        $criterion = new Criterion;

        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        $relativeKeys = Criterion::getInOperands();

        foreach ($relativeKeys as $key => $operand) {
            $criterion->setOperand($operand);

            // Test method
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertEquals('criterionToIn', $method);
        }
    }

    public function testCriterionOperandToInMethodFail()
    {
        // Create generic Criterion
        $criterion = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        // Get all available operands
        $criterionOperands = Criterion::$criterionOperands;

        // Remove operands resulting in `criterionToIn` method
        $relativeKeys = Criterion::getInOperands();

        foreach ($relativeKeys as $key) {
            $parentKey = array_search($key, $criterionOperands);

            if ($parentKey !== false) {
                unset($criterionOperands[$parentKey]);
            }
        }

        // Loop through remaining operands and check if they NOT resolve to `criterionToIn` method
        foreach ($criterionOperands as $key => $operand) {
            $criterion
                ->setOperand($operand);

            // Test each operand fails
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertNotEquals('criterionToIn', $method);
        }
    }

    public function testCriterionOperandToRegexMethod()
    {
        $criterion = new Criterion;

        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        $relativeKeys = Criterion::getRegexOperands();

        foreach ($relativeKeys as $key => $operand) {
            $criterion->setOperand($operand);

            // Test method
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertEquals('criterionToRegex', $method);
        }
    }

    public function testCriterionOperandToRegexMethodFail()
    {
        // Create generic Criterion
        $criterion = new Criterion;
        $criterion
            ->setLogic('and')
            ->setKey('name')
            ->setType('value')
            ->setValue('Jane');

        // Get all available operands
        $criterionOperands = Criterion::$criterionOperands;

        // Remove operands resulting in `criterionToRegex` method
        $relativeKeys = Criterion::getRegexOperands();

        foreach ($relativeKeys as $key) {
            $parentKey = array_search($key, $criterionOperands);

            if ($parentKey !== false) {
                unset($criterionOperands[$parentKey]);
            }
        }

        // Loop through remaining operands and check if they NOT resolve to `criterionToRegex` method
        foreach ($criterionOperands as $key => $operand) {
            $criterion
                ->setOperand($operand);

            // Test each operand fails
            $method = Db_Filter::criterionOperandToMethod($criterion);

            $this->assertNotEquals('criterionToRegex', $method);
        }
    }

    public function testCriteriaToSQLArrayCriterionAsString()
    {
        $criteria = array('and-name-re-value-Jane,John,Sam', 'and-surname-re-value-Doe', 'and-dob-re-field-age', 'and-dob-re-field-age');

        Db_Filter::criteriaToSql($criteria);
    }
}
