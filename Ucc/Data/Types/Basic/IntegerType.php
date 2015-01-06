<?php

namespace Ucc\Data\Types\Basic;

use Ucc\Data\Types\TypeInterface;
use Ucc\Exception\InvalidDataTypeException;

/**
 * Ucc\Data\Types\Basic\IntegerType
 * Defines IntegerType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class IntegerType implements TypeInterface
{
    public static $requirementsOptions = array(
        'min'       => 'Minimum allowable value',
        'max'       => 'Maximum allowable value',
        'values'    => 'List of allowable values',
        'odd'       => 'Must be an odd number',
        'even'      => 'Must be an even number',
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
     * @param   mixed   $value          Value to be checked
     * @param   array   $requirements   Additional constraints
     * @return  mixed   Cleared value
     * @throws  InvalidDataTypeException
     */
    public static function check($value, array $requirements = array())
    {
        // Check value is integer or numerical
        if ((ctype_digit($value) === false) && ((is_int($value)) === false)) {
            throw new InvalidDataTypeException("value must be an integer");
        }

        // Cast as integer and check if value meets the requirements
        $value = (int) $value;

        // Minimum value
        if (isset($requirements['min']) && $value < $requirements['min']) {
            $error = 'value must be greater than or equal to '.$requirements['min'];

            if (isset($requirements['max'])) {
                $error .= ' and less than or equal to '.$requirements['max'];
            }

            throw new InvalidDataTypeException($error);
        // Maximum value
        } elseif (isset($requirements['max']) && $value > $requirements['max']) {
            $error = 'value must be less than or equal to '.$requirements['max'];

            if (isset($requirements['min'])) {
                $error .= ' and greater than or equal to '.$requirements['min'];
            }

            throw new InvalidDataTypeException($error);
        // In values
        } elseif (isset($requirements['values']) && is_array($requirements['values'])) {
            if (!in_array($value, $requirements['values'])) {
                $error = 'value must be one of: '
                .implode(', ', $requirements['values']);

                throw new InvalidDataTypeException($error);
            }
        // Odd
        } elseif (isset($requirements['odd'])) {
            if (self::isOdd($value) === false) {
                throw new InvalidDataTypeException("value must be an odd number");
            }
        // Even
        } elseif (isset($requirements['even'])) {
            if (self::isOdd($value) === true) {
                throw new InvalidDataTypeException("value must be an even number");
            }
        }

        return $value;
    }

    /**
     * Checks if number is odd
     *
     * @param   integer   $number     Number to check
     * @return  boolean
     */
    private static function isOdd($number)
    {
        return ($number%2) ? true : false;
    }
}
