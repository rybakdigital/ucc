<?php

namespace Ucc\Data\Types\Basic;

use Ucc\Data\Types\TypeInterface;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;

/**
 * Ucc\Data\Types\Basic\StringType
 * Defines StringType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class StringType implements TypeInterface
{
    public static $requirementsOptions = array(
        'min'       => 'Minimum length',
        'max'       => 'Maximum length',
        'values'    => 'List of allowable values',
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
        if (!is_string($value)) {
            $error = 'value must be a string';

            throw new InvalidDataTypeException($error);
        }

        // Check the string matches a predefined list of values if supplied
        if (!empty($requirements['values'])) {
            if (!in_array($value, $requirements['values'])) {
                $error = 'value must be one of: '
                    . implode(', ', $requirements['values']);

                throw new InvalidDataValueException($error);
            }
        // Check min and max length if both options are supplied
        } elseif (isset($requirements['min']) && isset($requirements['max'])) {
            if (!(strlen($value) >= $requirements['min']) || !(strlen($value) <= $requirements['max'])) {
                $error = 'value length is outside of allowed range ('
                    . $requirements['min'] . ' to '
                    . $requirements['max'] . ')';

                throw new InvalidDataValueException($error);
            }
        }
        // Check min
        elseif (isset($requirements['min'])) {
            if (!(strlen($value) >= $requirements['min'])) {
                $error = 'value length must be greater than or'
                    . ' equal to ' . $requirements['min'];

                throw new InvalidDataValueException($error);
            }
        }
        // Check max
        elseif (isset($requirements['max'])) {
            if (!(strlen($value) <= $requirements['max'])) {
                $error = 'value length must be less than or'
                    . ' equal to ' . $requirements['max'];

                throw new InvalidDataValueException($error);
            }
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
