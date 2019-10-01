<?php

namespace Ucc\Tests\Data\Types\Basic;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Types\Basic\PhoneNumberType;

class PhoneNumberTypeTest extends TestCase
{
    public function testGetRequirementsOptions()
    {
        $this->assertTrue(is_array(PhoneNumberType::getRequirementsOptions()));
    }

    public function validPhoneNumberProvider()
    {
        return array(
            array('+447877775529'),
            array('+437877775529'),
            array('00447877775529', '+447877775529'),
            array('+12555296540', '+12555296540'),
            array('0012555296540', '+12555296540'),
            array('+33516598974', '+33516598974'),
            array('0033516598974', '+33516598974'),
            array('00385948741235', '+385948741235'),
            array('00359948741231', '+359948741231'),
            array('0032123456789874', '+32123456789874'),
            array('00321234567898', '+321234567898'),
        );
    }

    public function invalidPhoneNumberProvider()
    {
        return array(
            array('789787878778787'),
            array('00448787897878787877878787'),
            array('abc 123'),
            array('07877559988'),
            array('98777777777'),
            array('+6622345'),
            array('+6612234556'),
            array('+6622345678948'),
            array('+4407877552287'),
            array('+44787755228899'),
            array('+447877'),
            array('+335165989744'),
            array('+3287965412'),
            array('+321234567898741'),
        );
    }

    /**
     * @dataProvider    validPhoneNumberProvider
     */
    public function testCheckPass($phone, $expected = null)
    {
        if (is_null($expected)) {
            $expected = $phone;
        }

        $this->assertEquals(PhoneNumberType::check($expected), $phone);
    }

    /**
     * @dataProvider    validPhoneNumberProvider
     */
    public function testIsPass($phone)
    {
        $this->assertTrue(PhoneNumberType::is($phone));
    }

    /**
     * @dataProvider    invalidPhoneNumberProvider
     * @expectedException Ucc\Exception\Data\InvalidDataValueException
     */
    public function testCheckFail($phone)
    {
        $this->assertEquals(PhoneNumberType::check($phone), $phone);
    }

    /**
     * @dataProvider    invalidPhoneNumberProvider
     */
    public function testIsFail($phone)
    {
        $this->assertFalse(PhoneNumberType::is($phone));
    }
}
