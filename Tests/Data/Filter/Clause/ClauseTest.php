<?php

namespace Ucc\Tests\Data\Filter\Clause;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Filter\Clause\Clause;

class ClauseTest extends TestCase
{
    public function testClauseParameters()
    {
        $clause = new Clause();

        $this->assertTrue(is_array($clause->getParameters()));

        $parameters = array('foo' => 2, 'moo' => 'abc', 'loo' => 'ABC');

        $this->assertInstanceOf(get_class($clause), $clause->setParameters($parameters));
        $this->assertSame($parameters, $clause->getParameters());
        $this->assertEquals($parameters, $clause->getParameters());
    }

    public function testParameter()
    {
        $clause = new Clause();

        $this->assertNull($clause->getParameter('moo'));
        $this->assertInstanceOf(get_class($clause), $clause->setParameter('moo', 'foo'));
        $this->assertEquals('foo', $clause->getParameter('moo'));
        $this->assertEquals('foo', $clause->param('moo'));
    }

    public function testClauseStatement()
    {
        $clause     = new Clause();
        $statement  = $clause->getStatement();

        $this->assertTrue(empty($statement));
        $this->assertInstanceOf(get_class($clause), $clause->setStatement('abc'));
        $this->assertEquals('abc', $clause->getStatement('abc'));
        $this->assertEquals('abc', $clause->statement('abc'));
    }
}
