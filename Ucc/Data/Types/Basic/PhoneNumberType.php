<?php

namespace Ucc\Data\Types\Basic;

use Ucc\Data\Types\TypeInterface;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;

/**
 * Ucc\Data\Types\Basic\PhoneNumberType
 * Defines PhoneNumberType data
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class PhoneNumberType implements TypeInterface
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

        $value = self::checkInternationalNumber($value);

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

    public static function checkInternationalNumber($value)
    {
        // Array of country codes and the regex pattern
        // Ensure they are in order of longest country codes first.
        $countryNumberPlanRegexArray = array
        (
            '66' => '/^\+66[2-9][0-9]{7,8}$/',
            '49' => '/^\+49[1-9][0-9]{2,11}$/',
            '44' => '/^\+44[1-9][0-9]{6,10}$/',
            '39' => '/^\+39[0-9]{6,11}$/',
            '34' => '/^\+34[1-9][0-9]{2,8}$/',
            '33' => '/^\+33[1-9][0-9]{8}$/',
            '31' => '/^\+31[1-9][0-9]{8}$/',
            '1'  => '/^\+1[2-9][0-9]{9}$/',
        );

        $countryNumberPlanFormatDesc = array
        (
            '66'  => 'the Thai international numbering plan starts +66, followed'
                . ' by a digit between 2 and 9.'
                . ' Length Min:10 Max:11',
            '49' => 'the German international numbering plan starts +49, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:5 Max:14',
            '44' => 'the UK international numbering plan should start with a'
                . ' +44, followed by the phone number with the leading 0 removed.'
                . ' Length Min:7 Max:13',
            '39' => 'the Italian international numbering plan starts +39, followed'
                . ' by the phone number.'
                . ' Length Min:8 Max:13',
            '34' => 'the Spanish international numbering plan starts +34, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:5 Max:11',
            '33' => 'the French international numbering plan starts +33, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '31' => 'the Dutch international numbering plan starts +31, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '1'  => 'the US international numbering plan starts +1, followed'
                . ' by a digit between 2 and 9.'
                . ' Length Min:11 Max:11',
        );

        foreach($countryNumberPlanRegexArray as $countryCode => $regexPattern) {
            if (substr($value, 1, strlen($countryCode)) == $countryCode) {
                if (!preg_match($regexPattern , $value)) {
                    // Number plan validation failed
                    // return required format description
                    $error = $countryNumberPlanFormatDesc[$countryCode];

                    throw new InvalidDataValueException($error);
                }

                return $value;
            }
        }

        // If unknown country code, then reject.
        $error = 'value does not start with a supported country code ('
            . implode( ',', array_keys( $countryNumberPlanFormatDesc ) ) . ')' ;

        throw new InvalidDataValueException($error);
    }
}
