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

        $value = self::checkInternationalNumber($value, true);

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

    public static function checkInternationalNumber($value, $plusPrefix = false)
    {
        if ($plusPrefix) {
            if (substr(trim($value), 0, 2) == '00') {
                $value = substr_replace($value, '+', 0, 2);
            }
        }

        // Array of country codes and the regex pattern
        // Ensure they are in order of longest country codes first.
        $countryNumberPlanRegexArray = array
        (
            '998'   => '/^\+998[1-9][0-9]{8}$/',
            '996'   => '/^\+996[3-7][0-9]{8}$/',
            '995'   => '/^\+995[1-9][0-9]{8}$/',
            '994'   => '/^\+994[1-9][0-9]{8}$/',
            '993'   => '/^\+993[1-9][0-9]{7}$/',
            '992'   => '/^\+992[1-9][0-9]{8}$/',
            '98'    => '/^\+98[1-9][0-9]{9}$/',
            '977'   => '/^\+977[1-9][0-9]{7,9}$/',
            '976'   => '/^\+976[1-9][0-9]{7}$/',
            '975'   => '/^\+975[1-9][0-9]{6,7}$/',
            '974'   => '/^\+974[1-9][0-9]{2,7}$/',
            '973'   => '/^\+973[1-9][0-9]{7}$/',
            '972'   => '/^\+972[1-9][0-9]{7,8}$/',
            '971'   => '/^\+971[1-7,9][0-9]{7,8}$/',
            '970'   => '/^\+970[1-9][0-9]{7,8}$/',
            '968'   => '/^\+968[1-9][0-9]{7}$/',
            '967'   => '/^\+967[1-9][0-9]{6,8}$/',
            '966'   => '/^\+966[1-9][0-9]{8}$/',
            '965'   => '/^\+965[1-9][0-9]{6,7}$/',
            '964'   => '/^\+964[1-9][0-9]{8,9}$/',
            '963'   => '/^\+963[1-9][0-9]{6,8}$/',
            '962'   => '/^\+962[1-9][0-9]{7,8}$/',
            '961'   => '/^\+961[1-9][0-9]{6,7}$/',
            '960'   => '/^\+960[1-9][0-9]{6}$/',
            '95'    => '/^\+95[1-9][0-9]{5,9}$/',
            '94'    => '/^\+94[0-9]{9}$/',
            '93'    => '/^\+93[1-9][0-9]{7,8}$/',
            '92'    => '/^\+92[1-9][0-9]{9}$/',
            '91'    => '/^\+91[1-9][0-9]{9}$/',
            '90'    => '/^\+90[2-5][0-9]{9}$/',
            '886'   => '/^\+886[1-9][0-9]{7,8}$/',
            '880'   => '/^\+880[1-9][0-9]{9}$/',
            '86'    => '/^\+86[1-9][0-9]{8,10}$/',
            '856'   => '/^\+856[1-9][0-9]{7,9}$/',
            '855'   => '/^\+855[1-9][0-9]{7,8}$/',
            '853'   => '/^\+853[1-9][0-9]{7}$/',
            '852'   => '/^\+852[1-9][0-9]{7}$/',
            '84'    => '/^\+84[1-9][0-9]{7,10}$/',
            '82'    => '/^\+82[1-9][0-9]{7,9}$/',
            '81'    => '/^\+81[1-9][0-9]{8,9}$/',
            '77'    => '/^\+77[0-9]{9}$/',
            '66'    => '/^\+66[2-9][0-9]{7,8}$/',
            '65'    => '/^\+65[1-9][0-9]{7}$/',
            '590'   => '/^\+590[1-9][0-9]{8}$/',
            '58'    => '/^\+58[1-9][0-9]{9}$/',
            '57'    => '/^\+57[1-9][0-9]{5,11}$/',
            '56'    => '/^\+56[1-9][0-9]{7,9}$/',
            '55'    => '/^\+55[1-9][0-9]{9,10}$/',
            '54'    => '/^\+54[1-9][0-9]{6,11}$/',
            '53'    => '/^\+53[1-9][0-9]{4,10}$/',
            '52'    => '/^\+52[1-9][0-9]{5,9}$/',
            '51'    => '/^\+51[1-9][0-9]{6,10}$/',
            '509'   => '/^\+509[1-9][0-9]{7}$/',
            '508'   => '/^\+508[1-9][0-9]{5}$/',
            '507'   => '/^\+507[1-9][0-9]{6,7}$/',
            '506'   => '/^\+506[1-9][0-9]{7}$/',
            '505'   => '/^\+505[1-9][0-9]{7}$/',
            '504'   => '/^\+504[1-9][0-9]{6,7}$/',
            '503'   => '/^\+503[1-9][0-9]{7}$/',
            '502'   => '/^\+502[1-9][0-9]{7}$/',
            '501'   => '/^\+501[1-9][0-9]{6}$/',
            '500'   => '/^\+500[1-9][0-9]{4}$/',
            '49'    => '/^\+49[1-9][0-9]{2,11}$/',
            '48'    => '/^\+48[1-9][0-9]{8}$/',
            '47'    => '/^\+47[2-3,5-9][0-9]{7,11}$/',
            '46'    => '/^\+46[1-9][0-9]{6,12}$/',
            '45'    => '/^\+45[1-9][0-9]{7}$/',
            '44'    => '/^\+44[1-9][0-9]{6,10}$/',
            '43'    => '/^\+43[1-7][0-9]{3,10}$/',
            '423'   => '/^\+423[1-7][0-9]{6}$/',
            '421'   => '/^\+421[1-7][0-9]{8}$/',
            '420'   => '/^\+420[1-7][0-9]{8}$/',
            '41'    => '/^\+41[1-9][0-9]{8}$/',
            '40'    => '/^\+40[1-9][0-9]{8}$/',
            '39'    => '/^\+39[0-9]{6,11}$/',
            '386'   => '/^\+386[1-9][0-9]{7}$/',
            '385'   => '/^\+385[1-9][0-9]{5,9}$/',
            '372'   => '/^\+372[3-9][0-9]{6,7}$/',
            '371'   => '/^\+371[2-7][0-9]{7}$/',
            '370'   => '/^\+370[1-9][0-9]{7}$/',
            '36'    => '/^\+36[1-9][0-9]{6,9}$/',
            '359'   => '/^\+359[1-9][0-9]{5,8}$/',
            '358'   => '/^\+358[0-9]{6,9}$/',
            '357'   => '/^\+357[2,9][0-9]{7}$/',
            '356'   => '/^\+356[1-9][0-9]{7}$/',
            '354'   => '/^\+354[3-8][0-9]{6,7}$/',
            '353'   => '/^\+353[1,2,4-9][0-9]{7,8}$/',
            '352'   => '/^\+352[1-9][0-9]{5,8}$/',
            '351'   => '/^\+351[1-9][0-9]{8}$/',
            '350'   => '/^\+350[0-9]{8}$/',
            '34'    => '/^\+34[1-9][0-9]{2,8}$/',
            '33'    => '/^\+33[1-9][0-9]{8}$/',
            '32'    => '/^\+32[1-9][0-9]{7,11}$/',
            '31'    => '/^\+31[1-9][0-9]{8}$/',
            '30'    => '/^\+30[1-7][0-9]{8,9}$/',
            '27'    => '/^\+27[1-9][0-9]{8}$/',
            '264'   => '/^\+264[1-9][0-9]{7,8}$/',
            '249'   => '/^\+249[1,9][0-9]{8}$/',
            '234'   => '/^\+234[1-9][0-9]{7,9}$/',
            '216'   => '/^\+216[1-9][0-9]{7}$/',
            '20'    => '/^\+20[1-9][0-9]{9}$/',
            '1'     => '/^\+1[2-9][0-9]{9}$/',
        );

        $countryNumberPlanFormatDesc = array
        (
            '998'  => 'the Uzbek international numbering plan starts +998, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '996'  => 'the Kyrgyzstani international numbering plan starts +996, followed'
                . ' by a digit between 3 and 7 and 8 other digits.'
                . ' Length Min:12 Max:12',
            '995'  => 'the Georgian international numbering plan starts +995, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '994'  => 'the Azerbaijani international numbering plan starts +994, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '993'  => 'the Turkmenistani international numbering plan starts +993, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '992'  => 'the Tajikistani international numbering plan starts +992, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '98'  => 'the Iranian international numbering plan starts +98, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '977'  => 'the Nepalese international numbering plan starts +977, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:13',
            '976'  => 'the Mongolian international numbering plan starts +976, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '975'  => 'the Bhutanese international numbering plan starts +975, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:12',
            '974'  => 'the Qatar international numbering plan starts +974, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:6 Max:11',
            '973'  => 'the Bahraini international numbering plan starts +973, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '972'  => 'the Israeli international numbering plan starts +972, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:12',
            '971'  => 'the United Arabic Emirates international numbering plan starts +971, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:9 Max:11',
            '970'  => 'the Palestinian international numbering plan starts +970, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:12',
            '968'  => 'the Omani international numbering plan starts +968, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '967'  => 'the Yemeni international numbering plan starts +967, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:12',
            '966'  => 'the Saudi Arabia international numbering plan starts +966, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '965'  => 'the Kuwaiti international numbering plan starts +965, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:11',
            '964'  => 'the Iraqi international numbering plan starts +964, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:13',
            '963'  => 'the Syrian international numbering plan starts +963, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:12',
            '962'  => 'the Jordanian international numbering plan starts +962, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:12',
            '961'  => 'the Lebanese international numbering plan starts +961, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:11',
            '960'  => 'the Maldivian international numbering plan starts +960, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:10',
            '95'  => 'the Burmese international numbering plan starts +95, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:8 Max:12',
            '94'  => 'the Sri Lankan international numbering plan starts +94, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '93'  => 'the Afghan international numbering plan starts +93, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:11',
            '92'  => 'the Pakistani international numbering plan starts +92, followed'
                . ' by a digit between 1 and 9 and 9 other digits.'
                . ' Length Min:12 Max:12',
            '91'  => 'the Indian international numbering plan starts +91, followed'
                . ' by a digit between 2 and 9 and 9 other digits.'
                . ' Length Min:12 Max:12',
            '90'  => 'the Turkish international numbering plan starts +90, followed'
                . ' by a digit between 2 and 5 and 9 other digits.'
                . ' Length Min:12 Max:12',
            '886'  => 'the Taiwanese international numbering plan starts +886, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:12',
            '880'  => 'the Bangladeshi international numbering plan starts +880, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:13 Max:13',
            '86'  => 'the Chinese (Mainland) international numbering plan starts +86, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:13',
            '856' => 'the Laotian international numbering plan starts +856, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:13',
            '855' => 'the Cambodian international numbering plan starts +855, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:12',
            '853' => 'the Macau international numbering plan starts +853, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '852' => 'the Hong Kong international numbering plan starts +852, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '84'  => 'the Vietnamese international numbering plan starts +84, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:13',
            '82'  => 'the South Korean international numbering plan starts +82, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:12',
            '81'  => 'the Japanese international numbering plan starts +81, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:12',
            '77'  => 'the Kazakhstani international numbering plan starts +77, followed'
                . ' by a digit between 0 and 9.'
                . ' Length Min:11 Max:11',
            '66'  => 'the Thai international numbering plan starts +66, followed'
                . ' by a digit between 2 and 9.'
                . ' Length Min:10 Max:11',
            '65'  => 'the Singapore international numbering plan starts +65, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:10',
            '590' => 'the international numbering plan for Guadeloupe, Saint-Barthélemy and Saint-Martin starts +590, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:9 Max:9',
            '58' => 'the Venezuelan international numbering plan starts +58, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:10',
            '57' => 'the Colombian international numbering plan starts +57, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:6 Max:12',
            '56' => 'the Chilean international numbering plan starts +56, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:8 Max:10',
            '55' => 'the Brazilian international numbering plan starts +55, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:11',
            '54' => 'the Argentinian international numbering plan starts +54, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:7 Max:12',
            '53' => 'the Cuban international numbering plan starts +53, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:5 Max:11',
            '52' => 'the Mexican international numbering plan starts +52, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:6 Max:10',
            '51' => 'the Peruvian international numbering plan starts +51, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:7 Max:11',
            '509' => 'the Haitian international numbering plan starts +509, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:8 Max:8',
            '508' => 'the Saint-Pierrais international numbering plan starts +508, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:6 Max:6',
            '507' => 'the Panamanian international numbering plan starts +507, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:7 Max:8',
            '506' => 'the Costa Rican international numbering plan starts +506, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:8 Max:8',
            '505' => 'the Nicaraguan international numbering plan starts +505, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:8 Max:8',
            '504' => 'the Honduran international numbering plan starts +504, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:7 Max:8',
            '503' => 'the Salvadorian international numbering plan starts +503, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:8 Max:8',
            '502' => 'the Guatemalan international numbering plan starts +502, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:8 Max:8',
            '501' => 'the Belizean international numbering plan starts +501, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:7 Max:7',
            '500' => 'the Falkland Islands international numbering plan starts +500, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:5 Max:5',
            '49' => 'the German international numbering plan starts +49, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:5 Max:14',
            '48' => 'the Polish international numbering plan starts +48, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '47' => 'the Norwegian international numbering plan should start with a'
                . ' +47, followed by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:14',
            '46' => 'the Swedish international numbering plan should start with a'
                . ' +46, followed by the phone number with the leading 0 removed.'
                . ' Length Min:9 Max:15',
            '45' => 'the Danish international numbering plan should start with a'
                . ' +45, followed by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:10',
            '44' => 'the UK international numbering plan should start with a'
                . ' +44, followed by the phone number with the leading 0 removed.'
                . ' Length Min:7 Max:13',
            '43' => 'the Austrian international numbering plan should start with a'
                . ' +43, followed by the phone number with the leading 0 removed.'
                . ' Length Min:6 Max:13',
            '423' => 'the Liechtenstein international numbering plan starts +423, followed'
                . ' by a digit 1 or 7 and any 6 other digits.'
                . ' Length Min:10 Max:10',
            '421' => 'the Slovakian international numbering plan starts +421, followed'
                . ' by a digit 1 or 7 and any 8 other digits.'
                . ' Length Min:12 Max:12',
            '420' => 'the Czech international numbering plan starts +420, followed'
                . ' by a digit 1 or 7 and any 8 other digits.'
                . ' Length Min:12 Max:12',
            '41' => 'the Swiss international numbering plan starts +41, followed'
                . ' by the phone number.'
                . ' Length Min:11 Max:11',
            '40' => 'the Romanian international numbering plan starts +40, followed'
                . ' by the phone number.'
                . ' Length Min:11 Max:11',
            '39' => 'the Italian international numbering plan starts +39, followed'
                . ' by the phone number.'
                . ' Length Min:8 Max:13',
            '386' => 'the Slovenian international numbering plan starts +386, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '385' => 'the Croatian international numbering plan starts +385, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:9 Max:13',
            '372' => 'the Estonian international numbering plan starts +372, followed'
                . ' by a digit between 3 and 9 and 6 or 7 other digits.'
                . ' Length Min:9 Max:11',
            '371' => 'the Latvian international numbering plan starts +371, followed'
                . ' by a digit between 2 and 7 and 7 other digits.'
                . ' Length Min:11 Max:11',
            '370' => 'the Lithuanian international numbering plan starts +370, followed'
                . ' by a digit between 1 and 9 and 7 other digits.'
                . ' Length Min:11 Max:11',
            '36' => 'the Hungarian international numbering plan starts +36, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:9 Max:12',
            '359' => 'the Bulgarian international numbering plan starts +359, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:9 Max:12',
            '358' => 'the Finish international numbering plan starts +358, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:9 Max:12',
            '357' => 'the Cypriot international numbering plan starts +357, followed'
                . ' by a digit 2 or 9 and any 7 other digits.'
                . ' Length Min:11 Max:11',
            '356' => 'the Maltese international numbering plan starts +356, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '354' => 'the Icelandic international numbering plan starts +354, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:11',
            '353' => 'the Irish international numbering plan starts +353, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:12',
            '352' => 'the Luxembourg international numbering plan starts +352, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:9 Max:12',
            '351' => 'the Portuguese international numbering plan starts +351, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
            '350' => 'the Gibraltar international numbering plan starts +350, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '34' => 'the Spanish international numbering plan starts +34, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:5 Max:11',
            '33' => 'the French international numbering plan starts +33, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '32' => 'the Belgian international numbering plan starts +32, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:10 Max:14',
            '31' => 'the Dutch international numbering plan starts +31, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '30' => 'the Greek international numbering plan starts +30, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '27' => 'the South Africa international numbering plan starts +27, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '249'  => 'the Sudan international numbering plan starts +249, followed'
                . ' by 1 or 9 and 8 other digits.'
                . ' Length Min:12 Max:12',
            '264'  => 'the Namibia international numbering plan starts +264, followed'
                . ' by the phone number with the leading 0 removed'
                . ' Length Min:12 Max:13',
            '234'  => 'the Nigeria international numbering plan starts +234, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:13',
            '216'  => 'the Tunisia international numbering plan starts +216, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:11 Max:11',
            '20'  => 'the Egyptian international numbering plan starts +20, followed'
                . ' by the phone number with the leading 0 removed.'
                . ' Length Min:12 Max:12',
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
