<?php

namespace Ucc\Data\Types\Pseudo;

use Ucc\Data\Types\TypeInterface;
use Ucc\Filter\Sortable\Sort;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;
use \InvalidArgumentException;

/**
 * Ucc\Data\Types\Pseudo\SortType
 * Defines SortType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class SortType implements TypeInterface
{
    public static $requirementsOptions = array(
        'fields' => 'List of fields allowed for a sort',          // Example: array('foo', 'bar')
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
     * that the value passes requirements specified.
     *
     * @param   mixed   $value          Value to be checked
     * @param   array   $requirements   Additional constraints
     * @return  mixed   Cleared value
     * @throws  InvalidDataTypeException
     */
    public static function check($value, array $requirements = array())
    {
        if (!isset($requirements['fields'])) {
            $error = 'allowable list of fields constraint has not been specified for a sort';

            throw new InvalidDataTypeException($error);
        }

        if (!is_array($value)) {
            $error = 'value must be a list of sorts';

            throw new InvalidDataTypeException($error);
        }

        // reserve space for cleared sorts
        $sorts = array();

        // Iterate through the list of sorts and check each sort individually
        foreach ($value as $i => $sort) {
            // Detect sort settings
            if (!is_string($filter)) {
                $error = 'value for index '.$i
                    .' must be string in format of'
                    .' {field}-{direction}'
                    .' Example: id-asc, name-desc';

                throw new InvalidDataValueException($error);
            }

            // Get sort setting from string
            // All sorts should follow standard pattern:
            // {field}-{direction}
            // Example: id-desc
            $parts = explode('-', $filter, 2);

            if (!(count($parts) === 2)
                || !in_array($parts[0], $requirements['fields'])
                || !in_array($parts[1], Sort::$sortDirections)
                ){

                // Sort pattern does not match standard
                $error = 'value for index '.$i
                .', and part 1 (field) must be one of '
                .'('.implode(', ',$requirements['fields']).')'
                .', and part 2 (direction) must be one of '
                .'('.implode(', ', Sort::$sortDirections).')';

                throw new InvalidDataValueException($error);
            }

            $sort = new Sort();

            try {
                $sort
                    ->setField($parts[0])
                    ->setDirection($parts[1]);

                $sorts[] = $sort;
            } catch (InvalidArgumentException $e) {
                $error = 'value for sort index '.$i.', '
                    .'part 2 (direction) must be one of ('.implode(', ', Sort::$sortDirections).')';

                throw new InvalidDataValueException($error);
            }
        }

        return $sorts;
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
