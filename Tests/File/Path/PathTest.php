<?php

namespace Ucc\Tests\File\Path;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\File\Path\Path;

/**
 * @group Ucc
 * @group Ucc_File
 */
class PathTest extends TestCase
{
    public function ivalidPathsProvider()
    {
        return array(
            array(123),
            array(array()),
            array(new \StdClass())
        );
    }

    /**
     * @dataProvider            ivalidPathsProvider
     * @expectedException       InvalidArgumentException
     */
    public function testGetExtensionFailInvalidPath($path)
    {
        $this->assertTrue(is_string(Path::getExtentsion($path)));
    }

    public function pathsProvider()
    {
        return array(
            array("exe", "file.exe"),
            array("yaml", "some/yaml/file.yaml"),
            array("jpeg", ".files/file.jpeg"),
        );
    }

    /**
     * @dataProvider            pathsProvider
     */
    public function testGetExtension($expected, $path)
    {
        $this->assertSame($expected, Path::getExtentsion($path));
    }
}
