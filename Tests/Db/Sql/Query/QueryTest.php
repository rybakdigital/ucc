<?php

namespace Ucc\Tests\Db\Sql\Query;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Db\Sql\Query\Builder;

class QueryTest extends TestCase
{
    public function expandSimpleQueryProvider()
    {
        $data = array();

        $query      = '';
        $expected   = '';
        $data[]     = array($query, $expected);

        return $data;
    }

    /**
     * @dataProvider expandSimpleQueryProvider
     */
    public function testExpandSimpleQuery($query, $expected)
    {
        $result = Builder::expandSimpleQuery($query);
        $this->assertEquals($result, $expected);
    }
}
