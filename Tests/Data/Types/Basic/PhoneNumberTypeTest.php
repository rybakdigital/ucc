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
            array('00366123456789', '+366123456789'),
            array('00361234567', '+361234567'),
            array('003546121234', '+3546121234'),
            array('0035431212317', '+35431212317'),
            array('00353891234567', '+353891234567'),
            array('0035389123456', '+35389123456'),
            array('0037121212123', '+37121212123'),
            array('004231234567', '+4231234567'),
            array('0037052102222', '+37052102222'),
            array('00352412312', '+352412312'),
            array('+352691000700'),
            array('004791212123', '+4791212123'),
            array('0047591123123123', '+47591123123123'),
            array('0048121231212', '+48121231212'),
            array('+48121231212'),
            array('00351912123123', '+351912123123'),
            array('+351912123123'),
            array('0040123456789', '+40123456789'),
            array('+40123456789'),
            array('00421112345678', '+421112345678'),
            array('+421112345678'),
            array('0038611231212', '+38611231212'),
            array('+38611231212'),
            array('00461421231231231', '+461421231231231'),
            array('+461421231231231'),
            array('+41121231212'),
            array('0041121231212', '+41121231212'),
            array('+94779660448'),
            array('0094779660448', '+94779660448'),
            array('+905455351429'),
            array('00905455351429', '+905455351429'),
            array('+996323123456'),
            array('00996323123456', '+996323123456'),
            array('+919600017826'),
            array('00919600017826', '+919600017826'),
            array('+971552539371'),
            array('00971552539371', '+971552539371'),
            array('+923139646714'),
            array('+923332216990'),
            array('00923139646714', '+923139646714'),
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
            array('+3021234567'),
            array('+3021234567890'),
            array('+309123456789'),
            array('+3661234567891'),
            array('+36123456'),
            array('+3602345678'),
            array('+354612123'),
            array('+35261212'),
            array('+3538912345'),
            array('+3531212312345'),
            array('+353321231234'),
            array('+3712121212'),
            array('+371212121234'),
            array('+423123456'),
            array('+42312345678'),
            array('+3705210222'),
            array('+370521022222'),
            array('+35241231'),
            array('+3526910007001'),
            array('+479121212'),
            array('+475911231231231'),
            array('+47191123123123'),
            array('+47491123123123'),
            array('+4812123121'),
            array('+481212312112'),
            array('+35191212312'),
            array('+3519121231234'),
            array('+4012345678'),
            array('+401234567812'),
            array('+42111234567'),
            array('+4211123456789'),
            array('+3861123121'),
            array('+386112312123'),
            array('+4614212312312312'),
            array('+46142123'),
            array('+4112123121'),
            array('+411212312121'),
            array('+9477966044'),
            array('+947796604411'),
            array('+90545535142'),
            array('+9054553514291'),
            array('+99632312345'),
            array('+9963231234561'),
            array('+91960001782'),
            array('+9196000178261'),
            array('+9718525393'),
            array('+971852539371'),
            array('+9718525393712'),
            array('+9233322169902'),
            array('+92333221699'),
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
