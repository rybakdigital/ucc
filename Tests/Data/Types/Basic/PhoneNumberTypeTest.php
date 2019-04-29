<?php

namespace Ucc\Tests\Data\Types\Basic;

use PHPUnit\Framework\TestCase;
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
            array('00447877775529', '++447877775529'),
        );
    }

    public function invalidPhoneNumberProvider()
    {
        return array(
            array('789787878778787'),
            array('00448787897878787877878787'),
            array('abc 123'),
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
     * @expectedException Ucc\Exception\Data\InvalidDataTypeException
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
