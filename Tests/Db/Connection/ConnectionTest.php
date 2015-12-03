<?php

namespace Ucc\Tests\Db\Connection;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Db\Connection\Connection;

class ConnectionTest extends TestCase
{

    public function AutoSettersAndGettersProvider()
    {
        $data = array();

        // Test driver
        $data[] = array(
            array('driver' => 'mysql'), 'getDriver', 'mysql'
        );

        // Test host
        $data[] = array(
            array('host' => 'localhost'), 'getHost', 'localhost'
        );

        // Test port
        $data[] = array(
            array('port' => '80'), 'getPort', '80'
        );

        // Test dbName
        $data[] = array(
            array('dbname' => 'mydb'), 'getDbname', 'mydb'
        );

        // Test user
        $data[] = array(
            array('user' => 'username'), 'getUser', 'username'
        );

        // Test password
        $data[] = array(
            array('password' => '123'), 'getPassword', '123'
        );

        // Test charset (no data - default)
        $data[] = array(
            array(), 'getCharset', 'UTF8'
        );

        // Test charset
        $data[] = array(
            array('charset' => 'UTF8-CI'), 'getCharset', 'UTF8-CI'
        );

        // Test type (no data - default)
        $data[] = array(
            array(), 'getType', Connection::TYPE_PDO
        );

        // Test type
        $data[] = array(
            array('type' => Connection::TYPE_PDO), 'getType', Connection::TYPE_PDO
        );

        // Test unbuffered
        $data[] = array(
            array('unbuffered' => true), 'getUnbuffered', true
        );

        // Test unbuffered (default)
        $data[] = array(
            array(), 'getUnbuffered', false
        );

        // Test unbuffered (is) default
        $data[] = array(
            array(), 'isUnbuffered', false
        );

        // Test unbuffered (is)
        $data[] = array(
            array('unbuffered' => true), 'isUnbuffered', true
        );

        return $data;
    }

    /**
     * @dataProvider        AutoSettersAndGettersProvider
     */
    public function testAutoSettersAndGetters($options, $method, $expected)
    {
        $connection = new Connection($options);

        $this->assertEquals($expected, $connection->$method());
    }

    /**
     * @expectedException   Ucc\Exception\Db\DbConnectionException
     */
    public function testSetDriverFail()
    {
        $options = array('driver' => 'mydriver');
        $connection = new Connection($options);
    }

    /**
     * @expectedException   Ucc\Exception\Db\DbConnectionException
     */
    public function testSetTypeFail()
    {
        $options = array('type' => 'DOA');
        $connection = new Connection($options);
    }
}
