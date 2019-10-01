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
            array('0035726545238', '+35726545238'),
            array('0035792654789', '+35792654789'),
            array('00420522336655', '+420522336655'),
            array('00420602888999', '+420602888999'),
            array('004520998877', '+4520998877'),
            array('003727992222', '+3727992222'),
            array('0037279922222', '+37279922222'),
            array('00358471234567', '+358471234567'),
            array('00358501235', '+358501235'),
            array('0035020052200', '+35020052200'),
            array('00302123456789', '+302123456789'),
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
            array('+3351659897'),
            array('+328796541'),
            array('+321234567898741'),
            array('+32 12 34 56 78 98'),
            array('+32(0)123-4567 898'),
            array('+3579265478'),
            array('+357926547888'),
            array('+35712654789'),
            array('+42052233665'),
            array('+4205223366551'),
            array('+420922336655'),
            array('+452099887'),
            array('+45209988778'),
            array('+372799222'),
            array('+372799222222'),
            array('+3721992222'),
            array('+3584712345678'),
            array('+35850123'),
            array('+350200522001'),
            array('+3502005220'),
            array('+30212345678'),
            array('+3021234567890'),
            array('+309123456789'),
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
