<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Basic\EmailType;

class EmailTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(EmailType::getRequirementsOptions()));
    }

    public function validEmailProvider()
    {
        return array(
            array('jane.doe@example.com'),
            array('jane.doe21@example.co.uk'),
            array('jane.doe.21@example.com'),
            array('jane-doe.21@example.net'),
            array('jane.doe.21.savy.and.sassy@hotmail.com'),
        );
    }

    public function invalidEmailProvider()
    {
        return array(
            array('jane.doeexample.com'),
            array('jane.doe21.example.com'),
        );
    }

    /**
     * @dataProvider    validEmailProvider
     */
    public function testCheckPass($email)
    {
        $this->assertEquals(EmailType::check($email), $email);
    }

    /**
     * @dataProvider    validEmailProvider
     */
    public function testIsPass($email)
    {
        $this->assertTrue(EmailType::is($email));
    }

    /**
     * @dataProvider    invalidEmailProvider
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
     */
    public function testCheckFail($email)
    {
        $this->assertEquals(EmailType::check($email), $email);
    }

    /**
     * @dataProvider    invalidEmailProvider
     */
    public function testIsFail($email)
    {
        $this->assertFalse(EmailType::is($email));
    }
}
