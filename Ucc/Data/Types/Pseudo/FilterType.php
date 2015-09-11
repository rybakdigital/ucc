<?php

namespace Ucc\Data\Types\Pseudo;

use Ucc\Data\Types\TypeInterface;
use Ucc\Data\Filter\Criterion\Criterion;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;
use Ucc\Data\Filter\Filter;
use \InvalidArgumentException;

/**
 * Ucc\Data\Types\Pseudo\FilterType
 * Defines FilterType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class FilterType implements TypeInterface
{
    public static $requirementsOptions = array(
        'fields' => 'List of fields allowed for a filter',          // Example: array('foo', 'bar')
    );

    /**
     * Returns list of requirements options together with
     * their description.
     *
     * @return array
     */
    public static function getRequirementsOptions()
    {
        return self::$requirementsOptions;
    }

    /**
     * Checks if the value is of a given type and
     * passes the value the requirements specified.
     *
     * @param   array   $value          Value to be checked
     * @param   array   $requirements   Additional constraints
     * @return  Filter  Cleared value
     * @throws  InvalidDataTypeException | InvalidDataValueException
     */
    public static function check($value, array $requirements = array())
    {
        if (!isset($requirements['fields'])) {
            $error = 'allowable list of fields constraint has not been specified for a filter';

            throw new InvalidDataTypeException($error);
        }

        if (!is_array($value)) {
            $error = 'value must be a list of filters';

            throw new InvalidDataTypeException($error);
        }

        // reserve space for cleared filters
        $filter = new Filter;

        // Iterate through the list of filters and check each filter individually
        foreach ($value as $index => $criteria) {
            $criterion = self::criteriaToCriterion($criteria, $requirements, $index);
            $filter->addCriterion($criterion);
        }

        return $filter;
    }

    /**
     * Checks if the value is of a given type and
     * that the value passes requirements specified.
     *
     * @param   array   $value          Value to be checked
     * @param   array   $requirements   Additional constraints
     * @return  boolean                 True if value is of a given type and
     *                                  meets requirements
     */
    public static function is($value, array $requirements = array())
    {
        try {
            self::check($value, $requirements);
        } catch (InvalidDataException $e) {
            return false;
        }

        return true;
    }

    public static function criteriaToCriterion($filter, $requirements = array(), $index = 0)
    {
        // Detect filter settings
        if (!is_string($filter)) {
            $error = 'value for index '.$index
                .' must be a string in format of'
                .' {logic}-{field}-{operand}-{type}-{value}'
                .' Example: and-name-eq-value-smith';

            throw new InvalidDataValueException($error);
        }

        // Get filter setting from string
        // All filters should follow standard pattern:
        // {logic}-{field}-{operand}-{type}-{value}
        // Example: and-id-eq-value-12
        $parts = explode('-', $filter, 5);

        // Reserve space for error message in regards to fields
        $filedsPatternMessage = '';

        // Check for fields prerequisites if defined
        if (isset($requirements['fields'])) {
            $filedsPatternMessage = ', part 2 (field) must be one of '
                .'('.implode(', ',$requirements['fields']).')';

            if (!in_array($parts[1], $requirements['fields'])) {
                // Requirements miss match
                $error = 'value for index '.$index
                . $filedsPatternMessage;

                throw new InvalidDataValueException($error);
            }
        }

        if (!(count($parts) === 5)
            || !in_array($parts[0], Criterion::$criterionLogic)
            || !in_array($parts[2], Criterion::$criterionOperands)
            ){

            // Filter pattern does not match standard
            $error = 'value for index '.$index
            .', and part 1 (logic) must be one of '
            .'('.implode(', ', Criterion::$criterionLogic).')'
            . $filedsPatternMessage
            .', and part 3 (operand) must be one of '
            .'('.implode(', ', Criterion::$criterionOperands).')';

            throw new InvalidDataValueException($error);
        }

        // Check value for boolean operand is one of true ore false
        if (in_array($parts[2], Criterion::getBoolOperands())) {
            // Now that we know that this is boolean operand
            // let's check value is one of boolean type
            if (!in_array(strtolower($parts[4]), Criterion::$criterionBooleanValues)) {
                $error = 'value for index '.$index
                .', and part 5 (value) must be one of '
                .'('.implode(', ', Criterion::$criterionBooleanValues).')'
                .' when using boolean operand';

                throw new InvalidDataValueException($error);
            }
        }

        $criterion = new Criterion();

        try {
            $criterion
                ->setLogic($parts[0])
                ->setKey($parts[1])
                ->setOperand($parts[2])
                ->setType($parts[3])
                ->setValue($parts[4]);

        } catch (InvalidArgumentException $e) {
            $error = 'value for filter index '.$index.', '
                .'part 4 (type) must be one of (field or value)';

            throw new InvalidDataValueException($error);
        }

        return $criterion;
    }
}
