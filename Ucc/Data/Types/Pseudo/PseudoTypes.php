<?php

namespace Ucc\Data\Types\Pseudo;

use Ucc\Data\Types\Pseudo\FilterType;

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
     * @throws  InvalidDataException        If the value is not integer or fails constraints checks
     */
    public static function checkFilter($value, array $requirements)
    {
        return FilterType::check($value, $requirements);
    }
}
