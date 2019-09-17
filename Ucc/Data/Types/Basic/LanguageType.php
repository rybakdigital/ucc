<?php

namespace Ucc\Data\Types\Basic;

use Ucc\Data\Types\TypeInterface;
use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataValueException;
use Ucc\Exception\Data\InvalidDataException;

/**
 * Ucc\Data\Types\Basic\LanguageType
 * Defines LanguageType data as per ISO 639 combined with ISO 3166 two-letter uppercase subculture 
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class LanguageType implements TypeInterface
{
    public static $requirementsOptions = array(
        'code'   => 'Must be a language code, i.e. en-GB',  // Example: GB
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

    public static function languageCodeTypes()
    {
        return array(
            'alpha2',
            'alpha3',
            'iso3166',
        );
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
        $languages  = self::getLanguages();

        if (isset($requirements['code'])) {
            if (!in_array($requirements['code'], self::languageCodeTypes())) {
                throw new InvalidDataException("supported code types are " . implode(', ', self::languageCodeTypes()));
            }

            if (!array_key_exists($value, self::getLanguages($requirements['code']))) {
                throw new InvalidDataTypeException("value must be a valid language code type " . $requirements['code']);
            }
        } else {
            $type = 'name';
            if (!in_array($value, $countries)) {
                throw new InvalidDataTypeException("value must be a valid language name");
            }
        }

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

    /**
     * Get a list of Languages
     *
     * @return array
     */
    public static function getLanguages($type = 'iso3166') {
        $ret = array();

        foreach (self::$languages as $key => $language) {
            if (!isset($ret[$language[$type]])) {
                $ret[$language[$type]] = $language['name'];
            }
        }

        return $ret;
    }

    /**
     * Gets language name by its code
     */
    public static function getLanguageName($code, $type = 'iso3166')
    {
        $ret = array();

        foreach (self::$languages as $key => $language) {
            if (!isset($ret[$language[$type]])) {
                $ret[$language[$type]] = $language['name'];
            }
        }

        if (isset($ret[$code])) {
            return $ret[$code];
        }

        return null;
    }

    public static $languages = array(
        "aa" => array('alpha2'=>'aa', 'alpha3'=>'aar', 'iso3166' => 'aa', "name" => "Afar"),
        "ab" => array('alpha2'=>'ab', 'alpha3'=>'abk', 'iso3166' => 'aa', "name" => "Abkhazian"),
        "af" => array('alpha2'=>'af', 'alpha3'=>'afr', "name" => "Afrikaans"),
        "af" => array('alpha2'=>'af', 'alpha3'=>'afr', 'iso3166' => 'af-ZA', "name" => "Afrikaans (South Africa)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar', "name" => "Arabic"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-AE', "name" => "Arabic (U.A.E.)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-BH', "name" => "Arabic (Bahrain)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-DZ', "name" => "Arabic (Algeria)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-EG', "name" => "Arabic (Egypt)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-IQ', "name" => "Arabic (Iraq)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-JO', "name" => "Arabic (Jordan)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-KW', "name" => "Arabic (Kuwait)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-LB', "name" => "Arabic (Lebanon)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-LY', "name" => "Arabic (Libya)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-MA', "name" => "Arabic (Morocco)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-OM', "name" => "Arabic (Oman)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-QA', "name" => "Arabic (Qatar)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-SA', "name" => "Arabic (Saudi Arabia)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-SY', "name" => "Arabic (Syria)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-TN', "name" => "Arabic (Tunisia)"),
        "ar" => array('alpha2'=>'ar', 'alpha3'=>'ara', 'iso3166' => 'ar-YE', "name" => "Arabic (Yemen)"),
        "az" => array('alpha2'=>'az', 'alpha3'=>'aze', "name" => "Azeri (Latin)"),
        "az" => array('alpha2'=>'az', 'alpha3'=>'aze', 'iso3166' => 'ar-AZ', "name" => "Azeri (Latin-Azerbaijan)"),
        "be" => array('alpha2'=>'be', 'alpha3'=>'bel', "name" => "Belarusian"),
        "be" => array('alpha2'=>'be', 'alpha3'=>'bel', 'iso3166' => 'be-BY', "name" => "Belarusian (Belarus)"),
        "bg" => array('alpha2'=>'bg', 'alpha3'=>'bul', "name" => "Bulgarian"),
        "bg" => array('alpha2'=>'bg', 'alpha3'=>'bul', 'iso3166' => 'bg-BG', "name" => "Bulgarian (Bulgaria)"),
        "bs" => array('alpha2'=>'bs', 'alpha3'=>'bos', 'iso3166' => 'bs-BA', "name" => "Bosnian (Bosnia and Herzegovina)"),
        "ca" => array('alpha2'=>'ca', 'alpha3'=>'cat', "name" => "Catalan"),
        "ca" => array('alpha2'=>'ca', 'alpha3'=>'cat', 'iso3166' => 'ca-ES', "name" => "Catalan (Spain)"),
        "cs" => array('alpha2'=>'cs', 'alpha3'=>'cze', "name" => "Czech"),
        "cs" => array('alpha2'=>'cs', 'alpha3'=>'cze', 'iso3166' => 'cs-CZ', "name" => "Czech (Czech Republic)"),
        "cy" => array('alpha2'=>'cy', 'alpha3'=>'wel', "name" => "Welsh"),
        "cy" => array('alpha2'=>'cy', 'alpha3'=>'wel', 'iso3166' => 'cy-GB', "name" => "Welsh (United Kingdom)"),
        "da" => array('alpha2'=>'da', 'alpha3'=>'dan', "name" => "Danish"),
        "da" => array('alpha2'=>'da', 'alpha3'=>'dan', 'iso3166' => 'da-DK', "name" => "Danish (Denmark)"),
        "de" => array('alpha2'=>'de', 'alpha3'=>'ger', 'iso3166' => 'de', "name" => "German"),
        "de" => array('alpha2'=>'de', 'alpha3'=>'ger', 'iso3166' => 'de-AT', "name" => "German (Austria)"),
        "de" => array('alpha2'=>'de', 'alpha3'=>'ger', 'iso3166' => 'de-CH', "name" => "German (Switzerland)"),
        "de" => array('alpha2'=>'de', 'alpha3'=>'ger', 'iso3166' => 'de-DE', "name" => "German (Germany)"),
        "de" => array('alpha2'=>'de', 'alpha3'=>'ger', 'iso3166' => 'de-LI', "name" => "German (Liechtenstein)"),
        "de" => array('alpha2'=>'de', 'alpha3'=>'ger', 'iso3166' => 'de-LU', "name" => "German (Luxembourg)"),
        "dv" => array('alpha2'=>'de', 'alpha3'=>'div', "name" => "Divehi"),
        "dv" => array('alpha2'=>'de', 'alpha3'=>'div', 'iso3166' => 'dv-MV', "name" => "Divehi (Maldives)"),
        "el" => array('alpha2'=>'el', 'alpha3'=>'gre', "name" => "Greek"),
        "el" => array('alpha2'=>'el', 'alpha3'=>'gre', 'iso3166' => 'el-GR', "name" => "Greek (Greece)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en', "name" => "English"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-AU', "name" => "English (Australia)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-BZ', "name" => "English (Belize)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-CA', "name" => "English (Canada)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-CB', "name" => "English (Caribbean)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-GB', "name" => "English (United Kingdom)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-IE', "name" => "English (Ireland)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-JM', "name" => "English (Jamaica)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-NZ', "name" => "English (New Zealand)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-PH', "name" => "English (Republic of the Philippines)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-TT', "name" => "English (Trinidad and Tobago)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-US', "name" => "English (United States)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-ZA', "name" => "English (South Africa)"),
        "en" => array('alpha2'=>'en', 'alpha3'=>'eng', 'iso3166' => 'en-ZW', "name" => "English (Zimbabwe)"),
        "eo" => array('alpha2'=>'eo', 'alpha3'=>'epo', 'iso3166' => 'en', "name" => "Esperanto"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es', "name" => "Spanish"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-AR', "name" => "Spanish (Argentina)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-BO', "name" => "Spanish (Bolivia)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-CL', "name" => "Spanish (Chile)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-CO', "name" => "Spanish (Colombia)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-CR', "name" => "Spanish (Costa Rica)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-DO', "name" => "Spanish (Dominican Republic)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-EC', "name" => "Spanish (Ecuador)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-ES', "name" => "Spanish (Spain)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-ES', "name" => "Spanish (Castilian)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-GT', "name" => "Spanish (Guatemala)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-HN', "name" => "Spanish (Honduras)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-MX', "name" => "Spanish (Mexico)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-NI', "name" => "Spanish (Nicaragua)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-PA', "name" => "Spanish (Panama)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-PE', "name" => "Spanish (Peru)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-PR', "name" => "Spanish (Puerto Rico)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-PY', "name" => "Spanish (Paraguay)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-SV', "name" => "Spanish (El Salvador)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-UY', "name" => "Spanish (Uruguay)"),
        "es" => array('alpha2'=>'es', 'alpha3'=>'spa', 'iso3166' => 'es-VE', "name" => "Spanish (Venezuela)"),
        "et" => array('alpha2'=>'et', 'alpha3'=>'est', "name" => "Estonian"),
        "et" => array('alpha2'=>'et', 'alpha3'=>'est', 'iso3166' => 'et-EE', "name" => "Estonian (Estonia)"),
        "eu" => array('alpha2'=>'eu', 'alpha3'=>'baq', "name" => "Basque"),
        "eu" => array('alpha2'=>'eu', 'alpha3'=>'baq', 'iso3166' => 'eu-ES', "name" => "Basque (Spain)"),
        "fa" => array('alpha2'=>'fa', 'alpha3'=>'per', "name" => "Farsi"),
        "fa" => array('alpha2'=>'fa', 'alpha3'=>'per', 'iso3166' => 'fa-IR', "name" => "Farsi (Iran)"),
        "fi" => array('alpha2'=>'fi', 'alpha3'=>'fin', "name" => "Finnish"),
        "fi" => array('alpha2'=>'fi', 'alpha3'=>'fin', 'iso3166' => 'fi-FI', "name" => "Finnish (Finland)"),
        "fo" => array('alpha2'=>'fo', 'alpha3'=>'fao', "name" => "Faroese"),
        "fo" => array('alpha2'=>'fo', 'alpha3'=>'fao', 'iso3166' => 'fo-FO', "name" => "Faroese (Faroe Islands)"),
        "fr" => array('alpha2'=>'fr', 'alpha3'=>'fre', 'iso3166' => 'fr', "name" => "French"),
        "fr" => array('alpha2'=>'fr', 'alpha3'=>'fre', 'iso3166' => 'fr-BE', "name" => "French (Belgium)"),
        "fr" => array('alpha2'=>'fr', 'alpha3'=>'fre', 'iso3166' => 'fr-CA', "name" => "French (Canada)"),
        "fr" => array('alpha2'=>'fr', 'alpha3'=>'fre', 'iso3166' => 'fr-CH', "name" => "French (Switzerland)"),
        "fr" => array('alpha2'=>'fr', 'alpha3'=>'fre', 'iso3166' => 'fr-FR', "name" => "French (France)"),
        "fr" => array('alpha2'=>'fr', 'alpha3'=>'fre', 'iso3166' => 'fr-LU', "name" => "French (Luxembourg)"),
        "fr" => array('alpha2'=>'fr', 'alpha3'=>'fre', 'iso3166' => 'fr-MC', "name" => "French (Principality of Monaco)"),
        "gl" => array('alpha2'=>'gl', 'alpha3'=>'glg', "name" => "Galician"),
        "gl" => array('alpha2'=>'gl', 'alpha3'=>'glg', 'iso3166' => 'gl-ES', "name" => "Galician (Spain)"),
        "gu" => array('alpha2'=>'gu', 'alpha3'=>'guj', "name" => "Gujarati"),
        "gu" => array('alpha2'=>'gu', 'alpha3'=>'guj', 'iso3166' => 'gu-IN', "name" => "Gujarati (India)"),
        "he" => array('alpha2'=>'he', 'alpha3'=>'heb', "name" => "Hebrew"),
        "he" => array('alpha2'=>'he', 'alpha3'=>'heb', 'iso3166' => 'he-IL', "name" => "Hebrew (Israel)"),
        "hi" => array('alpha2'=>'hi', 'alpha3'=>'hin', "name" => "Hindi"),
        "hi" => array('alpha2'=>'hi', 'alpha3'=>'hin', 'iso3166' => 'hi-IN', "name" => "Hindi (India)"),
        "hr" => array('alpha2'=>'hr', 'alpha3'=>'hrv', 'iso3166' => 'hr', "name" => "Croatian"),
        "hr" => array('alpha2'=>'hr', 'alpha3'=>'hrv', 'iso3166' => 'hr-BA', "name" => "Croatian (Bosnia and Herzegovina)"),
        "hr" => array('alpha2'=>'hr', 'alpha3'=>'hrv', 'iso3166' => 'hr-HR', "name" => "Croatian (Croatia)"),
        "hu" => array('alpha2'=>'hu', 'alpha3'=>'hun', "name" => "Hungarian"),
        "hu" => array('alpha2'=>'hu', 'alpha3'=>'hun', 'iso3166' => 'hu-HU', "name" => "Hungarian (Hungary)"),
        "hy" => array('alpha2'=>'hy', 'alpha3'=>'arm', "name" => "Armenian"),
        "hy" => array('alpha2'=>'hy', 'alpha3'=>'arm', 'iso3166' => 'hy-AM', "name" => "Armenian (Armenia)"),
        "id" => array('alpha2'=>'id', 'alpha3'=>'ind', "name" => "Indonesian"),
        "id" => array('alpha2'=>'id', 'alpha3'=>'ind', 'iso3166' => 'id-ID', "name" => "Indonesian (Indonesia)"),
        "is" => array('alpha2'=>'is', 'alpha3'=>'ice', "name" => "Icelandic"),
        "is" => array('alpha2'=>'is', 'alpha3'=>'ice', 'iso3166' => 'is-IS', "name" => "Icelandic (Iceland)"),
        "it" => array('alpha2'=>'it', 'alpha3'=>'ita', 'iso3166' => 'it', "name" => "Italian"),
        "it" => array('alpha2'=>'it', 'alpha3'=>'ita', 'iso3166' => 'it-CH', "name" => "Italian (Switzerland)"),
        "it" => array('alpha2'=>'it', 'alpha3'=>'ita', 'iso3166' => 'it-IT', "name" => "Italian (Italy)"),
        "ja" => array('alpha2'=>'ja', 'alpha3'=>'jpn', "name" => "Japanese"),
        "ja" => array('alpha2'=>'ja', 'alpha3'=>'jpn', 'iso3166' => 'ja-JP', "name" => "Japanese (Japan)"),
        "ka" => array('alpha2'=>'ka', 'alpha3'=>'geo', "name" => "Georgian"),
        "ka" => array('alpha2'=>'ka', 'alpha3'=>'geo', 'iso3166' => 'ka-GE', "name" => "Georgian (Georgia)"),
        "kk" => array('alpha2'=>'kk', 'alpha3'=>'kaz', "name" => "Kazakh"),
        "kk" => array('alpha2'=>'kk', 'alpha3'=>'kaz', 'iso3166' => 'kk-KZ', "name" => "Kazakh (Kazakhstan)"),
        "kn" => array('alpha2'=>'kn', 'alpha3'=>'kan', "name" => "Kannada"),
        "kn" => array('alpha2'=>'kn', 'alpha3'=>'kan', 'iso3166' => 'kn-IN', "name" => "Kannada (India)"),
        "ko" => array('alpha2'=>'ko', 'alpha3'=>'kor', "name" => "Korean"),
        "ko" => array('alpha2'=>'ko', 'alpha3'=>'kor', 'iso3166' => 'ko-KR', "name" => "Korean (Korea)"),
        "kok" => array('alpha2'=>'kok', 'alpha3'=>'kok', "name" => "Konkani"),
        "kok" => array('alpha2'=>'kok', 'alpha3'=>'kok', 'iso3166' => 'kok-IN', "name" => "Konkani (India)"),
        "ky" => array('alpha2'=>'ky', 'alpha3'=>'kir', "name" => "Kyrgyz"),
        "ky" => array('alpha2'=>'ky', 'alpha3'=>'kir', 'iso3166' => 'ky-KG', "name" => "Kyrgyz (Kyrgyzstan)"),
        "lt" => array('alpha2'=>'lt', 'alpha3'=>'lit', "name" => "Lithuanian"),
        "lt" => array('alpha2'=>'lt', 'alpha3'=>'lit', 'iso3166' => 'lt-LT', "name" => "Lithuanian (Lithuania)"),
        "lv" => array('alpha2'=>'lv', 'alpha3'=>'lav', "name" => "Latvian"),
        "lv" => array('alpha2'=>'lv', 'alpha3'=>'lav', 'iso3166' => 'lv-LV', "name" => "Latvian (Latvia)"),
        "mi" => array('alpha2'=>'mi', 'alpha3'=>'mao', "name" => "Maori"),
        "mi" => array('alpha2'=>'mi', 'alpha3'=>'mao', 'iso3166' => 'mi-NZ', "name" => "Maori (New Zealand)"),
        "mk" => array('alpha2'=>'mk', 'alpha3'=>'mac', "name" => "FYRO Macedonian"),
        "mk" => array('alpha2'=>'mk', 'alpha3'=>'mac', 'iso3166' => 'mk-MK', "name" => "FYRO Macedonian (Former Yugoslav Republic of Macedonia)"),
        "mn" => array('alpha2'=>'mn', 'alpha3'=>'mon', "name" => "Mongolian"),
        "mn" => array('alpha2'=>'mn', 'alpha3'=>'mon', 'iso3166' => 'mn-MN', "name" => "Mongolian (Mongolia)"),
        "mr" => array('alpha2'=>'mr', 'alpha3'=>'mar', "name" => "Marathi"),
        "mr" => array('alpha2'=>'mr', 'alpha3'=>'mar', 'iso3166' => 'mr-IN', "name" => "Marathi (India)"),
        "ms" => array('alpha2'=>'ms', 'alpha3'=>'may', 'iso3166' => 'ms', "name" => "Malay"),
        "ms" => array('alpha2'=>'ms', 'alpha3'=>'may', 'iso3166' => 'ms-BN', "name" => "Malay (Brunei Darussalam)"),
        "ms" => array('alpha2'=>'ms', 'alpha3'=>'may', 'iso3166' => 'ms-MY', "name" => "Malay (Malaysia)"),
        "mt" => array('alpha2'=>'mt', 'alpha3'=>'mlt', "name" => "Maltese"),
        "mt" => array('alpha2'=>'mt', 'alpha3'=>'mlt', 'iso3166' => 'mt-MT', "name" => "Maltese (Malta)"),
        "nb" => array('alpha2'=>'nb', 'alpha3'=>'nob', "name" => "Norwegian (Bokmål)"),
        "nb" => array('alpha2'=>'nb', 'alpha3'=>'nob', 'iso3166' => 'nb-NO', "name" => "Norwegian (Bokmål)(Norway)"),
        "nl" => array('alpha2'=>'nl', 'alpha3'=>'dut', 'iso3166' => 'nl', "name" => "Dutch"),
        "nl" => array('alpha2'=>'nl', 'alpha3'=>'dut', 'iso3166' => 'nl-BE', "name" => "Dutch (Belgium)"),
        "nl" => array('alpha2'=>'nl', 'alpha3'=>'dut', 'iso3166' => 'nl-NL', "name" => "Dutch (Netherlands)"),
        "nn" => array('alpha2'=>'nn', 'alpha3'=>'nno', "name" => "Norwegian (Nynorsk)"),
        "nn" => array('alpha2'=>'nn', 'alpha3'=>'nno', 'iso3166' => 'nn-NO', "name" => "Norwegian (Nynorsk)(Norway)"),
        "ns" => array('alpha2'=>'ns', 'alpha3'=>'nso', "name" => "Northern Sotho"),
        "ns" => array('alpha2'=>'ns', 'alpha3'=>'nso', 'iso3166' => 'ns-ZA', "name" => "Northern Sotho (South Africa)"),
        "pa" => array('alpha2'=>'pa', 'alpha3'=>'pan', "name" => "Punjabi"),
        "pa" => array('alpha2'=>'pa', 'alpha3'=>'pan', 'iso3166' => 'pa-IN', "name" => "Punjabi (India)"),
        "pl" => array('alpha2'=>'pl', 'alpha3'=>'pol', "name" => "Polish"),
        "pl" => array('alpha2'=>'pl', 'alpha3'=>'pol', 'iso3166' => 'pl-PL', "name" => "Polish (Poland)"),
        "ps" => array('alpha2'=>'ps', 'alpha3'=>'pus', "name" => "Pashto"),
        "ps" => array('alpha2'=>'ps', 'alpha3'=>'pus', 'iso3166' => 'ps-AR', "name" => "Pashto (Afghanistan)"),
        "pt" => array('alpha2'=>'pt', 'alpha3'=>'por', 'iso3166' => 'pt', "name" => "Portuguese"),
        "pt" => array('alpha2'=>'pt', 'alpha3'=>'por', 'iso3166' => 'pt-BR', "name" => "Portuguese (Brazil)"),
        "pt" => array('alpha2'=>'pt', 'alpha3'=>'por', 'iso3166' => 'pt-PT', "name" => "Portuguese (Portugal)"),
        "qu" => array('alpha2'=>'qu', 'alpha3'=>'que', 'iso3166' => 'qu', "name" => "Quechua"),
        "qu" => array('alpha2'=>'qu', 'alpha3'=>'que', 'iso3166' => 'qu-BO', "name" => "Quechua (Bolivia)"),
        "qu" => array('alpha2'=>'qu', 'alpha3'=>'que', 'iso3166' => 'qu-EC', "name" => "Quechua (Ecuador)"),
        "qu" => array('alpha2'=>'qu', 'alpha3'=>'que', 'iso3166' => 'qu-PE', "name" => "Quechua (Peru)"),
        "ro" => array('alpha2'=>'ro', 'alpha3'=>'rum', "name" => "Romanian"),
        "ro" => array('alpha2'=>'ro', 'alpha3'=>'rum', 'iso3166' => 'ro-RO', "name" => "Romanian (Romania)"),
        "ru" => array('alpha2'=>'ru', 'alpha3'=>'rus', "name" => "Russian"),
        "ru" => array('alpha2'=>'ru', 'alpha3'=>'rus', 'iso3166' => 'ru-RU', "name" => "Russian (Russia)"),
        "sa" => array('alpha2'=>'sa', 'alpha3'=>'san', "name" => "Sanskrit"),
        "sa" => array('alpha2'=>'sa', 'alpha3'=>'san', 'iso3166' => 'sa-IN', "name" => "Sanskrit (India)"),
        "se" => array('alpha2'=>'se', 'alpha3'=>'sme', 'iso3166' => 'se', "name" => "Sami (Northern)"),
        "se" => array('alpha2'=>'se', 'alpha3'=>'sme', 'iso3166' => 'se-FI', "name" => "Sami (Northern)(Finland)"),
        "se" => array('alpha2'=>'se', 'alpha3'=>'sme', 'iso3166' => 'se-NO', "name" => "Sami (Northern)(Norway)"),
        "se" => array('alpha2'=>'se', 'alpha3'=>'smj', 'iso3166' => 'se-NO', "name" => "Sami (Lule)(Norway)"),
        "se" => array('alpha2'=>'se', 'alpha3'=>'sma', 'iso3166' => 'se-NO', "name" => "Sami (Southern)(Norway)"),
        "se" => array('alpha2'=>'se', 'alpha3'=>'sme', 'iso3166' => 'se-SE', "name" => "Sami (Northern)(Sweden)"),
        "se" => array('alpha2'=>'se', 'alpha3'=>'smj', 'iso3166' => 'se-SE', "name" => "Sami (Lule)(Sweden)"),
        "se" => array('alpha2'=>'se', 'alpha3'=>'sma', 'iso3166' => 'se-SE', "name" => "Sami (Southern)(Sweden)"),
        "sk" => array('alpha2'=>'sk', 'alpha3'=>'slo', "name" => "Slovak"),
        "sk" => array('alpha2'=>'sk', 'alpha3'=>'slo', 'iso3166' => 'sk-SK', "name" => "Slovak (Slovakia)"),
        "sl" => array('alpha2'=>'sl', 'alpha3'=>'slv', "name" => "Slovenian"),
        "sl" => array('alpha2'=>'sl', 'alpha3'=>'slv', 'iso3166' => 'sl-SI', "name" => "Slovenian (Slovenia)"),
        "sq" => array('alpha2'=>'sq', 'alpha3'=>'alb', 'iso3166' => 'sq', "name" => "Albanian"),
        "sq" => array('alpha2'=>'sq', 'alpha3'=>'alb', 'iso3166' => 'sq-AL', "name" => "Albanian (Albania)"),
        "sr" => array('alpha2'=>'sr', 'alpha3'=>'srp', 'iso3166' => 'sr-BA', "name" => "Serbian (Latin) (Bosnia and Herzegovina)"),
        "sr" => array('alpha2'=>'sr', 'alpha3'=>'srp', 'iso3166' => 'sr-SP', "name" => "Serbian (Latin) (Serbia and Montenegro)"),
        "sv" => array('alpha2'=>'sv', 'alpha3'=>'swe', 'iso3166' => 'sv', "name" => "Swedish"),
        "sv" => array('alpha2'=>'sv', 'alpha3'=>'swe', 'iso3166' => 'sv-FI', "name" => "Swedish (Finland)"),
        "sv" => array('alpha2'=>'sv', 'alpha3'=>'swe', 'iso3166' => 'sv-SE', "name" => "Swedish (Sweden)"),
        "sw" => array('alpha2'=>'sw', 'alpha3'=>'swa', "name" => "Swahili"),
        "sw" => array('alpha2'=>'sw', 'alpha3'=>'swa', 'iso3166' => 'sw-KE', "name" => "Swahili (Kenya)"),
        "syr" => array('alpha2'=>'syr', 'alpha3'=>'syr', "name" => "Syriac"),
        "syr" => array('alpha2'=>'syr', 'alpha3'=>'syr', 'iso3166' => 'syr-SY', "name" => "Syriac (Syria)"),
        "ta" => array('alpha2'=>'ta', 'alpha3'=>'tam', "name" => "Tamil"),
        "ta" => array('alpha2'=>'ta', 'alpha3'=>'tam', 'iso3166' => 'ta-IN', "name" => "Tamil (India)"),
        "te" => array('alpha2'=>'te', 'alpha3'=>'tel', "name" => "Telugu"),
        "te" => array('alpha2'=>'te', 'alpha3'=>'tel', 'iso3166' => 'te-IN', "name" => "Telugu (India)"),
        "th" => array('alpha2'=>'th', 'alpha3'=>'tha', "name" => "Thai"),
        "th" => array('alpha2'=>'th', 'alpha3'=>'tha', 'iso3166' => 'th-TH', "name" => "Thai (Thailand)"),
        "tl" => array('alpha2'=>'tl', 'alpha3'=>'tgl', "name" => "Tagalog"),
        "tl" => array('alpha2'=>'tl', 'alpha3'=>'tgl', 'iso3166' => 'tl-PH', "name" => "Tagalog (Philippines)"),
        "tn" => array('alpha2'=>'tn', 'alpha3'=>'tsn', "name" => "Tswana"),
        "tn" => array('alpha2'=>'tn', 'alpha3'=>'tsn', 'iso3166' => 'tn-ZA', "name" => "Tswana (South Africa)"),
        "tr" => array('alpha2'=>'tr', 'alpha3'=>'tur', "name" => "Turkish"),
        "tr" => array('alpha2'=>'tr', 'alpha3'=>'tur', 'iso3166' => 'tr-TR', "name" => "Turkish (Turkey)"),
        "tt" => array('alpha2'=>'tt', 'alpha3'=>'tat', "name" => "Tatar"),
        "tt" => array('alpha2'=>'tt', 'alpha3'=>'tat', 'iso3166' => 'tt-RU', "name" => "Tatar (Russia)"),
        "ts" => array('alpha2'=>'ts', 'alpha3'=>'tso', 'iso3166' => 'ts', "name" => "Tsonga"),
        "uk" => array('alpha2'=>'uk', 'alpha3'=>'ukr', "name" => "Ukrainian"),
        "uk" => array('alpha2'=>'uk', 'alpha3'=>'ukr', 'iso3166' => 'uk-UA', "name" => "Ukrainian (Ukraine)"),
        "ur" => array('alpha2'=>'ur', 'alpha3'=>'urd', "name" => "Urdu"),
        "ur" => array('alpha2'=>'ur', 'alpha3'=>'urd', 'iso3166' => 'ur-PK', "name" => "Urdu (Islamic Republic of Pakistan)"),
        "uz" => array('alpha2'=>'uz', 'alpha3'=>'uzb', "name" => "Uzbek"),
        "uz" => array('alpha2'=>'uz', 'alpha3'=>'uzb', 'iso3166' => 'uz-UZ', "name" => "Uzbek (Latin) (Uzbekistan)"),
        "vi" => array('alpha2'=>'vi', 'alpha3'=>'vie', "name" => "Vietnamese"),
        "vi" => array('alpha2'=>'vi', 'alpha3'=>'vie', 'iso3166' => 'vi-VN', "name" => "Vietnamese (Viet Nam)"),
        "xh" => array('alpha2'=>'xh', 'alpha3'=>'xho', "name" => "Xhosa"),
        "xh" => array('alpha2'=>'xh', 'alpha3'=>'xho', 'iso3166' => 'xh-ZA', "name" => "Xhosa (South Africa)"),
        "zh" => array('alpha2'=>'zh', 'alpha3'=>'chi', 'iso3166' => 'zh', "name" => "Chinese"),
        "zh" => array('alpha2'=>'zh', 'alpha3'=>'chi', 'iso3166' => 'zh-CN', "name" => "Chinese (S)"),
        "zh" => array('alpha2'=>'zh', 'alpha3'=>'chi', 'iso3166' => 'zh-HK', "name" => "Chinese (Hong Kong)"),
        "zh" => array('alpha2'=>'zh', 'alpha3'=>'chi', 'iso3166' => 'zh-MO', "name" => "Chinese (Macau)"),
        "zh" => array('alpha2'=>'zh', 'alpha3'=>'chi', 'iso3166' => 'zh-SG', "name" => "Chinese (Singapore)"),
        "zh" => array('alpha2'=>'zh', 'alpha3'=>'chi', 'iso3166' => 'zh-TW', "name" => "Chinese (T)"),
        "zu" => array('alpha2'=>'zu', 'alpha3'=>'zul', "name" => "Zulu"),
        "zu" => array('alpha2'=>'zu', 'alpha3'=>'zul', 'iso3166' => 'zu-ZA', "name" => "Zulu (South Africa)"),
    );
}
