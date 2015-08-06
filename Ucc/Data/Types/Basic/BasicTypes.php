<?php

namespace Ucc\Data\Types\Basic;

use Ucc\Data\Types\Basic\IntegerType;
use Ucc\Data\Types\Basic\StringType;

/**
 * Ucc\Data\Types\Basic\BasicTypes
 * Defines checks for basic types
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class BasicTypes
{
    public static $knownTypes = array(
        'int'       => 'checkInteger',
        'str'       => 'checkString',
        'string'    => 'checkString',
    );

    /**
     * Checks if value is an integer
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints (OPTIONAL)
     * @return  integer     Cleared value
     * @throws  InvalidDataException        If the value is not integer or fails constraints checks
     */
    public static function checkInteger($value, array $requirements = array())
    {
        return IntegerType::check($value, $requirements);
    }

    /**
     * Checks if value is a string
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints (OPTIONAL)
     * @return  integer     Cleared value
     * @throws  InvalidDataException        If the value is not integer or fails constraints checks
     */
    public static function checkString($value, array $requirements = array())
    {
        return StringType::check($value, $requirements);
    }
}
