<?php

namespace Ucc\Tests\Crypt;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Crypt\Hash;

class HashTest extends TestCase
{
    public function passwordProvider()
    {
        return array(
            array('abc123'),
            array('abc123', 'abc1234USJDjs'),
            array('abc123', 'abc1234UsSJDjs', 3),
            array('abc123', 'abc123s', 13),
            array('abc123', Hash::generateSalt(), 13),
        );
    }

    /**
     * @dataProvider passwordProvider
     */
    public function testHashPassword($password, $salt = null, $rounds = null)
    {
        $hash = Hash::hashPassword($password, $salt, $rounds);
        $this->assertTrue($hash instanceof Hash);

        if ($salt) {
            $this->assertEquals($salt, $hash->getSalt());
        }

        if ($rounds) {
            $this->assertEquals($rounds, $hash->getRounds());
        }
    }

    public function objectProvider()
    {
        return array(
            array('abc123'),
            array(array(), 'abc1234USJDjs'),
            array(new Hash, 'abc1234UsSJDjs', 3),
            array(new \StdClass, 'abc123s', 13),
            array('abc123', Hash::generateSalt(), 13),
            array('abc123', Hash::generateSalt(), 5, 'sha256'),
            array('abc123', Hash::generateSalt(), 5, 'sha1'),
        );
    }

    /**
     * @dataProvider objectProvider
     */
    public function testHash($object, $salt = null, $rounds = null, $algo = null)
    {
        $hash = Hash::hash($object, $salt, $rounds, $algo);
        $this->assertTrue($hash instanceof Hash);
        $this->assertTrue(is_string($hash->getHash()));

        if ($salt) {
            $this->assertEquals($salt, $hash->getSalt());
        }

        if ($rounds) {
            $this->assertEquals($rounds, $hash->getRounds());
        }

        if ($algo) {
            $this->assertEquals($algo, $hash->getAlgo());
        }
    }

    public function object256Provider()
    {
        return array(
            array('abc123'),
            array(array(), 'abc1234USJDjs'),
            array(new Hash, 'abc1234UsSJDjs', 3),
            array(new \StdClass, 'abc123s', 13),
            array('abc123', Hash::generateSalt(), 13),
            array('abc123', Hash::generateSalt(), 5),
            array('abc123', Hash::generateSalt(), 5),
        );
    }

    /**
     * @dataProvider object256Provider
     */
    public function testHash256($object, $salt = null, $rounds = null)
    {
        $hash = Hash::hash256($object, $salt, $rounds);
        $this->assertTrue($hash instanceof Hash);
        $this->assertTrue(is_string($hash->getHash()));

        if ($salt) {
            $this->assertEquals($salt, $hash->getSalt());
        }

        if ($rounds) {
            $this->assertEquals($rounds, $hash->getRounds());
        }

        $this->assertEquals('sha256', $hash->getAlgo());
    }

    public function saltConfigProvider()
    {
        return array(
            array(),
            array(128),
            array(15, false),
            array(15, true),
            array(null, false),
        );
    }

    /**
     * @dataProvider saltConfigProvider
     */
    public function testGenerateSalt($lenght = null, $useBase64 = null)
    {
        $salt = Hash::generateSalt($lenght, $useBase64);

        $this->assertTrue(is_string($salt));

        if ($lenght) {
            $this->assertEquals($lenght, strlen($salt));
        }
    }

    public function testGetBase62()
    {
        $base = Hash::getBase62();

        $this->assertTrue(is_array($base));
        $this->assertEquals(62, count($base));
    }

    public function testGetBase64()
    {
        $base = Hash::getBase64();

        $this->assertTrue(is_array($base));
        $this->assertEquals(64, count($base));
    }
}
