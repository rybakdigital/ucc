<?php

namespace Ucc\Data\Types\Pseudo;

use Ucc\Data\Types\TypeInterface;
use Ucc\Filter\Criterion\Criterion;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;
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
     * @return  array   Cleared value
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
        $filters = array();

        // Iterate through the list of filters and check each filter individually
        foreach ($value as $i => $filter) {
            // Detect filter settings
            if (!is_string($filter)) {
                $error = 'value for index '.$i
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

            if (!(count($parts) === 5)
                || !in_array($parts[0], Criterion::$criterionLogic)
                || !in_array($parts[1], $requirements['fields'])
                || !in_array($parts[2], Criterion::$criterionOperands)
                ){

                // Filter pattern does not match standard
                $error = 'value for index '.$i
                .', and part 1 (logic) must be one of '
                .'('.implode(', ', Criterion::$criterionLogic).')'
                .', part 2 (field) must be one of '
                .'('.implode(', ',$requirements['fields']).')'
                .', and part 3 (operand) must be one of '
                .'('.implode(', ', Criterion::$criterionOperands).')';

                throw new InvalidDataValueException($error);
            }

            $filter = new Criterion();

            try {
                $filter
                    ->setLogic($parts[0])
                    ->setKey($parts[1])
                    ->setOperand($parts[2])
                    ->setType($parts[3])
                    ->setValue($parts[4]);

                $filters[] = $filter;
            } catch (InvalidArgumentException $e) {
                $error = 'value for filter index '.$i.', '
                    .'part 4 (type) must be one of (field or value)';

                throw new InvalidDataValueException($error);
            }
        }

        return $filters;
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
}
