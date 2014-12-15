<?php

namespace Ucc\Tests\Fundation;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Fundation\Config;

class ConfigTest extends TestCase
{
    public function testGetParameterTrue()
    {
        $config = new Config();

        $config->setParameter('foo', 'boo');

        $this->assertSame('boo', $config->getParameter('foo'));
    }

    /**
     * @expectedException     Ucc\Exception\ParameterNotFoundException
     */
    public function testGetParameterFalse()
    {
        $config = new Config();

        $config->getParameter('foo');
    }

    public function testHasParameterTrue()
    {
        $config = new Config();

        $config->setParameter('foo', 'boo');

        $this->assertTrue($config->hasParameter('foo'));
    }

    public function testHasParameterFalse()
    {
        $config = new Config();

        $this->assertFalse($config->hasParameter('moo'));
    }

    public function testGetParameterBag()
    {
        $config = new Config();

        $this->assertInstanceOf('Ucc\Fundation\ParameterBag\ParameterBag', $config->getParameterBag());
    }
}
