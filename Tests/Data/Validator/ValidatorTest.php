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

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Argument 1 passed to Ucc\Data\Validator\Validator::setChecks() must be of the type array
     */
    public function testSetChecksFail()
    {
        $validator  = new Validator;
        $checks     = true;
        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checks));
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
        $checks     = array('name' => array('type' => 'int'));
        $this->assertInstanceOf(get_class($validator), $validator->setChecks($checks));
        $this->assertEquals($checks, $validator->getChecks());
        $this->assertInstanceOf(get_class($validator), $validator->clearChecks());
        $this->assertEmpty($validator->getChecks());
    }
}
