<?php

namespace Ucc\Sortable\Sort;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Sortable\Sort\Sort;

class SortTest extends TestCase
{
    public function testGetField()
    {
        $sort       = new Sort();
        $expected   = 'name';
        $this->assertInstanceOf('Ucc\Sortable\Sort\Sort', $sort->setField($expected));
        $this->assertSame($expected, $sort->getField());
        $this->assertSame($expected, $sort->field());
    }

    public function testGetDirection()
    {
        $sort       = new Sort();
        $expected   = 'asc';
        $this->assertInstanceOf('Ucc\Sortable\Sort\Sort', $sort->setDirection($expected));
        $this->assertSame($expected, $sort->getDirection());
        $this->assertSame($expected, $sort->direction());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected Sort->direction to be one of
     */
    public function testSetDirectionFail()
    {
        $sort       = new Sort();
        $expected   = 'dadasdas';
        $sort->setDirection($expected);
    }
}
