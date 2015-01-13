<?php

namespace Ucc\Data\Format\Format;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Data\Format\Format\Format;

class FormatTest extends TestCase
{
    public function testGetFormat()
    {
        $format     = new Format();
        $expected   = 'json';
        $this->assertInstanceOf(get_class($format), $format->setFormat($expected));
        $this->assertSame($expected, $format->getFormat());
        $this->assertSame($expected, $format->format());
    }

    public function testToString()
    {
        $format     = new Format();
        $expected   = 'json';

        $format->setFormat('json');
        $this->assertSame($expected, $format->toString());
    }
}
