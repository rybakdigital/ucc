<?php

namespace Ucc\Tests\Config\ParameterBag;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Config\ParameterBag\ParameterBag;

class ParameterBagTest extends TestCase
{
    // Test ParameterBag->clear()
    public function testClear()
    {
        // Crete new ParameterBag with some data
        $parameterBag = new ParameterBag(array('foo' => 'boo'));

        // Clean parameters and check if chain method is preserved
        $this->assertInstanceOf('Ucc\Config\ParameterBag\ParameterBag', $parameterBag->clear());

        // Check if result is empty
        $this->assertEmpty($parameterBag->getAll());
    }

    // Test ParameterBag->add()
    public function testAdd()
    {
        // Create new ParameterBag with some pre-existing parameters
        $preExistingParams = array('foo' => 'boo');
        $parameterBag = new ParameterBag($preExistingParams);

        // Add more parameters to ParameterBag and check if chain method is preserved
        $toBeAddedParams = array('moo' => 'soo');
        $this->assertInstanceOf('Ucc\Config\ParameterBag\ParameterBag', $parameterBag->add($toBeAddedParams));

        $expected   = array_merge($preExistingParams, $toBeAddedParams);
        $actual     = $parameterBag->getAll();

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    // Test ParameterBag->set() 
    public function testSet()
    {
        $parameterBag = new ParameterBag(array('moo' => 'loo'));

        $parameters = array(
            'Foo' => 'boo', // The key should be changed to lowercase
            'moo' => 'soo', // This should overwrite existing 'moo' parameter
        );

        $expected = $parameterBag->getAll();

        foreach ($parameters as $parameter => $value) {
            // Set parameters and check if chain method is preserved
            $this->assertInstanceOf('Ucc\Config\ParameterBag\ParameterBag', $parameterBag->set($parameter, $value));

            // Build expected value array
            $expected[strtolower($parameter)] = $value;
        }

        $actual = $parameterBag->getAll();

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    // Test ParameterBag->get()
    public function testGet()
    {
        $param          = array('moo' => 'loo');
        $parameterBag   = new ParameterBag($param);

        $actual         = $parameterBag->get('moo');
        $expected       = $param['moo'];

        // Compare actual and existing params
        $this->assertSame($expected, $actual);
    }

    // Test ParameterBag->get() fail
    /**
     * @expectedException     Ucc\Exception\ParameterNotFoundException
     */
    public function testGetFail()
    {
        $parameterBag = new ParameterBag();

        // This should throw exception
        $moo = $parameterBag->get('moo');
    }

    // Test ParameterBag->has()
    public function testHas()
    {
        $param          = array('moo' => 'loo');
        $parameterBag   = new ParameterBag($param);

        $this->assertTrue($parameterBag->has('moo'));
    }

    // Test ParameterBag->has()
    public function testHasFail()
    {
        $parameterBag   = new ParameterBag();

        $this->assertFalse($parameterBag->has('moo'));
    }
}
