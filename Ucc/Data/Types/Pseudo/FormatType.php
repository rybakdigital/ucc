<?php

namespace Ucc\Data\Types\Pseudo;

use Ucc\Data\Types\TypeInterface;
use Ucc\Data\Format\Format\Format;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;
use \InvalidArgumentException;

/**
 * Ucc\Data\Types\Pseudo\FormatType
 * Defines FormatType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class FormatType implements TypeInterface
{
    public static $requirementsOptions = array(
        'values' => 'List of supported formats',        // Example: array('foo', 'bar')
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
     * @return  string  Cleared value
     * @throws  InvalidDataTypeException
     */
    public static function check($value, array $requirements = array())
    {
        // Default format options
        $allowedFormats = Format::$formatOptions;

        if (!is_string($value)) {
            $error = 'value must be one of: '
                .implode(', ', $allowedFormats);

            throw new InvalidDataTypeException($error);
        }

        // Make sure format is alwas lowercase
        $value  = strtolower((string) $value);
        $format = new Format();

        // Override list of supported formats if set
        if (!empty($requirements['values']) && is_array($requirements['values'])) {
            $allowedFormats = $requirements['values'];
        }

        if (!in_array($value, $allowedFormats)) {
            $error = 'value must be one of: '
                .implode(', ', $allowedFormats);

            throw new InvalidDataValueException($error);
        }

        $format->setFormat($value);

        return $format;
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
