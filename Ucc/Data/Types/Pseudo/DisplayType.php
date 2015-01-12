<?php

namespace Ucc\Data\Types\Pseudo;

use Ucc\Data\Types\TypeInterface;
use Ucc\Data\Format\Display\Display;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;
use \InvalidArgumentException;

/**
 * Ucc\Data\Types\Pseudo\DisplayType
 * Defines DisplayType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class DisplayType implements TypeInterface
{
    public static $requirementsOptions = array(
        'fields' => 'List of fields to display or to alias',          // Example: array('foo', 'bar')
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
            $error = 'list of fields to display constraint has not been specified for display';

            throw new InvalidDataTypeException($error);
        }

        if (!is_array($value)) {
            $error = 'value must be a list of fields';

            throw new InvalidDataTypeException($error);
        }

        $displays = array();

        // Iterate through the list of fields and check each display
        foreach ($value as $i => $field) {
            // Detect display settings
            $parts = explode('-', $field, 2);

            if (!empty($parts[0])) {
                $error = 'value for index '.$i
                    .' must contain valid field names';

                throw new InvalidDataValueException($error);
            }

            if (!in_array($parts[0], $requirements['fields']) {
                $error = 'value for index '.$i
                    .' must be one of ('.implode(', ', $requirements['fields']).')';

                throw new InvalidDataValueException($error);
            }

            $display = new Display();

            $display->setField($parts[0]);

            if (!empty($parts[1])) {
                $display->setAlias($parts[1]);
            }

            $displays[] = $display;
        }

        return $displays;
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
