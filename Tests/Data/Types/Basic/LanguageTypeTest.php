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
            array('en-GB', 'English (United Kingdom)'),
            array('es-ES', 'Spanish (Spain)'),
            array('fr-CA', 'French (Canada)'),
            array('zh-CN', 'Chinese (S)'),
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
