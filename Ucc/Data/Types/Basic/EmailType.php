<?php

namespace Ucc\Data\Types\Basic;

use Ucc\Data\Types\TypeInterface;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;

/**
 * Ucc\Data\Types\Basic\EmailType
 * Defines EmailType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class EmailType implements TypeInterface
{
    /**
     * Returns list of requirements options together with
     * their description allowed for a given type.
     *
     * @return array
     */
    public static function getRequirementsOptions()
    {
        return array();
    }

    /**
     * Checks if the value is of a given type and
     * that the value passes requirements specified.
     *
     * @param   mixed   $value          Value to be checked
     * @param   array   $requirements   Additional constraints
     * @return  mixed   Cleared value
     * @throws  InvalidDataTypeException
     */
    public static function check($value, array $requirements = array())
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $value;
        }

        throw new InvalidDataTypeException("value must be a valid E-Mail address");
    }

    /**
     * Checks if the value is of a given type and
     * that the value passes requirements specified.
     *
     * @param   mixed   $value          Value to be checked
     * @param   array   $requirements   Additional constraints
     * @return  boolean                 True if value is of a given type and
     *                                  meets requirements
     * @throws  InvalidDataTypeException
     */
    public static function is($value, array $requirements = array()){
        try {
            self::check($value, $requirements);
        } catch (InvalidDataException $e) {
            return false;
        }

        return true;
    }
}
