<?php

namespace Ucc\Tests\Db\Result;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Db\Result\Result;

class ResultTest extends TestCase
{

    /**
     * @dataProvider statementProvider
     */
    public function testGetStatement($statement, $expected)
    {
        $result = new Result($statement);

        $this->assertSame($expected, $result->getStatement());
    }

    public function statementProvider()
    {
        $PDOstatement  = new \PDOStatement;

        $data = array(
            array($PDOstatement, $PDOstatement),
        );

        return $data;
    }

    /**
     * @dataProvider statementProviderFail
     * @expectedException   InvalidArgumentException
     */
    public function testGetStatementFail($statement, $expected)
    {
        $result = new Result($statement);

        $this->assertSame($expected, $result->getStatement());
    }

    public function statementProviderFail()
    {
        $statement  = new \StdClass;

        $data = array(
            array($statement, $statement),
        );

        return $data;
    }

    public function testGetAll()
    {
        $statement  = new \PDOStatement;
        $result     = new Result($statement);
        $this->assertFalse($result->getAll());
    }

    public function testGetNext()
    {
        $statement  = new \PDOStatement;
        $result     = new Result($statement);
        $this->assertFalse($result->getNext());
    }

    public function testGetRowCount()
    {
        $statement  = new \PDOStatement;
        $result     = new Result($statement);
        $this->assertFalse($result->getRowCount());
    }
}
