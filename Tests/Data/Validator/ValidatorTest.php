<?php

namespace Ucc\Tests\Data\Validator;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Validator\Validator;

class ValidatorTest extends TestCase
{
    public function testGetChecks()
    {
        $validator = new Validator;

        $this->assertTrue(is_array($validator->getChecks()));
    }

    public function testSetChecks()
    {
        $validator  = new Validator;
        $checks     = array('name' => array('type' => 'int'));
        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checks));
        $this->assertEquals($checks, $validator->getChecks());
    }

    public function testClearChecks()
    {
        $validator  = new Validator;
        $checks     = array('name' => array('type' => 'int'));
        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checks));
        $this->assertEquals($checks, $validator->getChecks());
        $this->assertInstanceOf(get_class($validator), $validator->clearChecks());
        $this->assertEmpty($validator->getChecks());
    }
}
