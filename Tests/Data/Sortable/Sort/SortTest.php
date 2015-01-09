<?php

namespace Ucc\Data\Sortable\Sort;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Sortable\Sort\Sort;

class SortTest extends TestCase
{
    public function testGetField()
    {
        $sort       = new Sort();
        $expected   = 'name';
        $this->assertInstanceOf(get_class($sort), $sort->setField($expected));
        $this->assertSame($expected, $sort->getField());
        $this->assertSame($expected, $sort->field());
    }

    public function testGetDirection()
    {
        $sort       = new Sort();
        $expected   = 'asc';
        $this->assertInstanceOf(get_class($sort), $sort->setDirection($expected));
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

    public function testToString()
    {
        $sort  = new Sort();
        $expected   = 'id-asc';

        $sort
            ->setField('id')
            ->setDirection('asc');

        $this->assertSame($expected, $sort->toString());
    }
}
