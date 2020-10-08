<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Basic\LanguageType;

class LanguageTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(LanguageType::getRequirementsOptions()));
    }

    public function validLanguageProvider()
    {
        return array(
            array('English (United Kingdom)', 'English (United Kingdom)'),
            array('Spanish (Spain)', 'Spanish (Spain)'),
            array('en-GB', 'English (United Kingdom)', 'iso3166'),
            array('es-ES', 'Spanish (Spain)', 'iso3166'),
            array('fr-CA', 'French (Canada)', 'iso3166'),
            array('zh-CN', 'Chinese (S)', 'iso3166'),
            array('en', 'English', 'iso3166'),
            array('en', 'English', 'alpha2'),
        );
    }

    /**
     * @dataProvider    validLanguageProvider
     */
    public function testCheckPass($code, $name, $type = null)
    {
        $requirements = array(
            'type' => $type
        );

        $this->assertEquals(LanguageType::check($code, $requirements), $code);
    }

    /**
     * @dataProvider    validLanguageProvider
     */
    public function testIsPass($code)
    {
        $this->assertTrue(LanguageType::is($code));
    }
}
