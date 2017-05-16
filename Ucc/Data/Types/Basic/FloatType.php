<?php

namespace Ucc\Data\Types\Basic;

use Ucc\Data\Types\TypeInterface;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;

/**
 * Ucc\Data\Types\Basic\FloatType
 * Defines FloatType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class FloatType implements TypeInterface
{
    public static $requirementsOptions = array(
        'min'       => 'Minimum allowable value',       // Example: 1
        'max'       => 'Maximum allowable value',       // Example: 999
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
     * @throws  InvalidDataTypeException | InvalidDataValueException
     */
    public static function check($value, array $requirements = array())
    {
        $res = filter_var($value, FILTER_VALIDATE_FLOAT);

        // Check value is float type
        if ($res === false) {
            throw new InvalidDataTypeException("value must be a float");
        }

        // Cast as float and check if value meets the requirements
        $value = (float) $value;

        // Minimum value
        if (isset($requirements['min']) && $value < $requirements['min']) {
            $error = 'value must be greater than or equal to '.$requirements['min'];

            if (isset($requirements['max'])) {
                $error .= ' and less than or equal to '.$requirements['max'];
            }

            throw new InvalidDataValueException($error);
        // Maximum value
        } elseif (isset($requirements['max']) && $value > $requirements['max']) {
            $error = 'value must be less than or equal to '.$requirements['max'];

            if (isset($requirements['min'])) {
                $error .= ' and greater than or equal to '.$requirements['min'];
            }

            throw new InvalidDataValueException($error);
        }

        return $value;
    }

    /**
     * Checks if the value is of a given type and
     * that the value passes requirements specified.
     *
     * @param   mixed   $value          Value to be checked
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
