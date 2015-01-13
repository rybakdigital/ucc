<?php

namespace Ucc\Data\Types\Pseudo;

use Ucc\Data\Types\Pseudo\DisplayType;
use Ucc\Data\Types\Pseudo\FilterType;
use Ucc\Data\Types\Pseudo\SortType;
use Ucc\Data\Types\Pseudo\FormatType;

/**
 * Ucc\Data\Types\Pseudo\PseudoTypes
 * Defines checks for pseudo types
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class PseudoTypes
{
    /**
     * Checks if value is a Filter
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints
     * @return  array       Cleared value
     * @throws  InvalidDataException        If the value is not a Filter or fails constraints checks
     */
    public static function checkFilter($value, array $requirements)
    {
        return FilterType::check($value, $requirements);
    }

    /**
     * Checks if value is a Sort
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints
     * @return  array       Cleared value
     * @throws  InvalidDataException        If the value is not a Sort or fails constraints checks
     */
    public static function checkSort($value, array $requirements)
    {
        return SortType::check($value, $requirements);
    }

    /**
     * Checks if value is a Display
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints
     * @return  array       Cleared value
     * @throws  InvalidDataException        If the value is not a Display or fails constraints checks
     */
    public static function checkDisplay($value, array $requirements)
    {
        return DisplayType::check($value, $requirements);
    }

    /**
     * Checks if value is a Format
     *
     * @param   mixed       $value          Value to evaluate
     * @param   array       $requirements   Array of constraints
     * @return  array       Cleared value
     * @throws  InvalidDataException        If the value is not a Format or fails constraints checks
     */
    public static function checkFormat($value, array $requirements)
    {
        return FormatType::check($value, $requirements);
    }
}
