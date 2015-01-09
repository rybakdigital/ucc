<?php

namespace Ucc\Data\Format\Display;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Format\Display\Display;

class DisplayTest extends TestCase
{
    public function testGetField()
    {
        $display       = new Display();
        $expected   = 'name';
        $this->assertInstanceOf(get_class($display), $display->setField($expected));
        $this->assertSame($expected, $display->getField());
        $this->assertSame($expected, $display->field());
    }

    public function testGetAlias()
    {
        $display       = new Display();
        $expected   = 'name';
        $this->assertInstanceOf(get_class($display), $display->setAlias($expected));
        $this->assertSame($expected, $display->getAlias());
        $this->assertSame($expected, $display->alias());
    }

    public function testToString()
    {
        $display  = new Display();
        $expected = 'product_id-id';

        $display
            ->setField('product_id')
            ->setAlias('id');

        $this->assertSame($expected, $display->toString());
    }

    public function testToStringNoAlias()
    {
        $display  = new Display();
        $expected = 'product';

        $display
            ->setField('product');

        $this->assertSame($expected, $display->toString());
    }
}
