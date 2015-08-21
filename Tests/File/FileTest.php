<?php

namespace Ucc\Tests\File;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\File\File;

/**
 * @group Ucc
 * @group Ucc_File
 */
class FileTest extends TestCase
{
    public function getInvlidFilename()
    {
        return array(
            array(null),
            array("something-that-does-not/exsts/file.png"),
        );
    }

    /**
     * @dataProvider            getInvlidFilename
     * @expectedException       InvalidArgumentException
     */
    public function testGetContentFailWithException($fileName)
    {
        $this->assertTrue(is_string(File::getContent($fileName)));
    }

    /**
     * @dataProvider            getInvlidFilename
     * @expectedException       InvalidArgumentException
     */
    public function testLoadFailWithException($fileName)
    {
        $this->assertTrue(is_string(File::load()));
    }

    public function filesProvider()
    {
        return array(
            array('Tests/_resources/content.txt', 'abcdefg
'),
            array('Tests/_resources/content.json', '{"menu": "property"}
'),
        );
    }

    /**
     * @dataProvider            filesProvider
     */
    public function testGetContent($fileName, $expected)
    {
        $this->assertEquals($expected, File::getContent($fileName));
    }
}
