<?php

namespace Ucc\Tests\Data\Validator\Check;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Validator\Check\Check;

class CheckTest extends TestCase
{
    public function testGetKey()
    {
        $check = new Check;
        $this->assertNull($check->getKey());
    }

    public function testSetKey()
    {
        $check = new Check;
        $key = 'name';
        $this->assertInstanceOf(get_class($check), $check->setKey($key));
        $this->assertEquals($key, $check->getKey());
    }

    public function testGetRequirements()
    {
        $check = new Check;
        $this->assertTrue(is_array($check->getRequirements()));
    }

    public function testSetRequirements()
    {
        $check = new Check;
        $requirements = array('opt' => true, 'min' => 1);
        $this->assertInstanceOf(get_class($check), $check->setRequirements($requirements));
        $this->assertEquals($requirements, $check->getRequirements());
    }

    public function testAddRequirement()
    {
        $check = new Check;
        $requirements = array('opt' => true, 'min' => 1);
        foreach ($requirements as $rule => $condition) {
            $this->assertInstanceOf(get_class($check), $check->addRequirement($rule, $condition));
        }
        
        $this->assertEquals($requirements, $check->getRequirements());
    }

    public function testFromArray()
    {
        $check  = new Check;
        $key    = "name";

        $requirements = array(
            'type'  => 'string',
            'min'   => 10,
            'opt'   => false,
        );

        $this->assertInstanceOf(get_class($check), $check->fromArray(array($key => $requirements)));
        $this->assertEquals($requirements, $check->getRequirements());
        $this->assertEquals($key, $check->getKey());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Argument 1 passed to Ucc\Data\Validator\Check\Check::fromArray() must be of the type array
     */
    public function testFromArrayFail()
    {
        $check  = new Check;
        $this->assertInstanceOf(get_class($check), $check->fromArray('abc'));
    }
}
