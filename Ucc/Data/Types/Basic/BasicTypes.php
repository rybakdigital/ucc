<?php

namespace Ucc\Data\Types\Basic;

use Ucc\Data\Types\Basic\IntegerType;
use Ucc\Data\Types\Basic\FloatType;
use Ucc\Data\Types\Basic\StringType;
use Ucc\Data\Types\Basic\EmailType;
use Ucc\Data\Types\Basic\BooleanType;
use Ucc\Data\Types\Basic\CountryType;
use Ucc\Data\Types\Basic\ArrayType;

/**
 * Ucc\Data\Types\Basic\BasicTypes
 * Defines checks for basic types
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class BasicTypes
{
    public static $knownTypes = array(
        'bool'      => 'checkBoolean',
        'boolean'   => 'checkBoolean',
        'int'       => 'checkInteger',
        'float'     => 'checkFloat',
        'str'       => 'checkString',
        'string'    => 'checkString',
        'email'     => 'checkEmail',
        'country'   => 'checkCountry',
        'array'     => 'checkArray',
        'list'      => 'checkArray',
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
     * Checks if value is a float
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints (OPTIONAL)
     * @return  float       Cleared value
     * @throws  InvalidDataException        If the value is not float or fails constraints checks
     */
    public static function checkFloat($value, array $requirements = array())
    {
        return FloatType::check($value, $requirements);
    }

    /**
     * Checks if value is a string
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints (OPTIONAL)
     * @return  string      Cleared value
     * @throws  InvalidDataException        If the value is not string or fails constraints checks
     */
    public static function checkString($value, array $requirements = array())
    {
        return StringType::check($value, $requirements);
    }

    /**
     * Checks if value is a valid email
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints (OPTIONAL)
     * @return  string      Cleared value
     * @throws  InvalidDataException        If the value is not email or fails constraints checks
     */
    public static function checkEmail($value, array $requirements = array())
    {
        return EmailType::check($value, $requirements);
    }

    /**
     * Checks if value is a valid boolean
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints (OPTIONAL)
     * @return  string      Cleared value
     * @throws  InvalidDataException        If the value is not boolean or fails constraints checks
     */
    public static function checkBoolean($value, array $requirements = array())
    {
        return BooleanType::check($value, $requirements);
    }

    /**
     * Checks if value is a valid country
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints (OPTIONAL)
     * @return  string      Cleared value
     * @throws  InvalidDataException        If the value is not country or fails constraints checks
     */
    public static function checkCountry($value, array $requirements = array())
    {
        return CountryType::check($value, $requirements);
    }

    /**
     * Checks if value is a valid array
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints (OPTIONAL)
     * @return  string      Cleared value
     * @throws  InvalidDataException        If the value is not country or fails constraints checks
     */
    public static function checkArray($value, array $requirements = array())
    {
        return ArrayType::check($value, $requirements);
    }
}
