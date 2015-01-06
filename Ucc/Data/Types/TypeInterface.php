<?php

namespace Ucc\Data\Types;

/**
 * Ucc\Data\Types\TypeInterface.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
interface TypeInterface
{
    /**
     * Returns list of requirements options together with
     * their description allowed for a given type.
     *
     * @return array
     */
    public static function getRequirementsOptions();

    /**
     * Checks if the value is of a given type and
     * that the value passes requirements specified.
     *
     * @param   mixed   $value          Value to be checked
     * @param   array   $requirements   Additional constraints
     * @return  mixed   Cleared value
     * @throws  InvalidDataTypeException
     */
    public static function check($value, array $requirements = array());

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
    public static function is($value, array $requirements = array());
}
