<?php

namespace Ucc\Tests\Data\Validator;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Validator\Validator;
use Ucc\Data\Validator\Check\Check;

class ValidatorTest extends TestCase
{
    public function testGetChecks()
    {
        $validator = new Validator;

        $this->assertTrue(is_array($validator->getChecks()));
    }

    public function testSetChecks()
    {
        $validator     = new Validator;
        $firstCheck    = array(
            'name'  => array('type' => 'string', 'min' => 1)
            );
        $secondCheck    = array(
            'age'   => array('type' => 'int', 'default' => 18, 'opt' => false),
            );

        $nameCheck      = new Check();
        $nameCheck->fromArray($firstCheck);

        $ageCheck      = new Check();
        $ageCheck->fromArray($secondCheck);

        $checks         = array($nameCheck, $ageCheck);
        $expected       = array('name' => $nameCheck, 'age' => $ageCheck);

        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checks));
        $this->assertEquals($expected, $validator->getChecks());
    }

    public function testSetChecksFromArray()
    {
        $validator     = new Validator;
        $checksArray   = array(
            'name'  => array('type' => 'string', 'min' => 1),
            'age'   => array('type' => 'int', 'default' => 18, 'opt' => false),
            );

        $firstCheck    = array(
            'name'  => array('type' => 'string', 'min' => 1)
            );
        $secondCheck    = array(
            'age'   => array('type' => 'int', 'default' => 18, 'opt' => false),
            );

        $nameCheck      = new Check();
        $nameCheck->fromArray($firstCheck);

        $ageCheck      = new Check();
        $ageCheck->fromArray($secondCheck);

        $checks         = array($nameCheck, $ageCheck);
        $expected       = array('name' => $nameCheck, 'age' => $ageCheck);

        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checksArray));
        $this->assertEquals($expected, $validator->getChecks());
    }

    public function testGetError()
    {
        $validator = new Validator;

        $this->assertFalse(is_array($validator->getError()));
    }

    public function testSetError()
    {
        $validator = new Validator;
        $message = 'Foo has made boo';
        $this->assertInstanceOf(get_class($validator), $validator->setError($message));
        $this->assertEquals($message, $validator->getError());
    }

    public function testClearChecks()
    {
        $validator  = new Validator;
        $firstCheck    = array(
            'name'  => array('type' => 'string', 'min' => 1)
            );
        $secondCheck    = array(
            'age'   => array('type' => 'int', 'default' => 18, 'opt' => false),
            );

        $nameCheck      = new Check();
        $nameCheck->fromArray($firstCheck);

        $ageCheck      = new Check();
        $ageCheck->fromArray($secondCheck);

        $checks         = array($nameCheck, $ageCheck);
        $expected       = array('name' => $nameCheck, 'age' => $ageCheck);

        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checks));
        $this->assertEquals($expected, $validator->getChecks());
        $this->assertInstanceOf(get_class($validator), $validator->clearChecks());
        $this->assertEmpty($validator->getChecks());
    }
}