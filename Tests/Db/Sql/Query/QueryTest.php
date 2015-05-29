<?php

namespace Ucc\Tests\Db\Sql\Query;

use \PHPUnit_Framework_TestCase as TestCase;
use Ucc\Db\Sql\Query\Query;
use Ucc\Data\Sortable\Sort\Sort;
use Ucc\Data\Filter\Filter;
use Ucc\Data\Types\Pseudo\FilterType;

class QueryTest extends TestCase
{
    public function expandSimpleQueryProvider()
    {
        $data       = array();
        $options    = array();

        $query      = new Query;
        $sql        = 'SELECT * FROM `products` ';
        $expectedSql = 'SELECT * FROM `products` WHERE (`name` LIKE CONCAT("%", :0_filter_0, "%") COLLATE utf8_general_ci OR `name` LIKE CONCAT("%", :0_filter_1, "%") COLLATE utf8_general_ci AND `price` > :0_filter_2) GROUP BY `name`,`price` ORDER BY `name` ASC,`price` ASC';
        $query
            ->setStatement($sql);
        $expected   = new Query;
        $expected
            ->setStatement($expectedSql);

        $sort1 = new Sort;
        $sort1->setField('name');
        $sort2 = new Sort;
        $sort2->setField('price');

        $filterA     = new Filter();
        $criterions = array(
            FilterType::filterToCriterion('and-name-inci-value-galaxy'),
            FilterType::filterToCriterion('or-name-inci-value-4s'),
            FilterType::filterToCriterion('and-price-gt-value-100'),
        );
        $filterA->setCriterions($criterions);


        $options = array('sort' => array($sort1, $sort2), 'group' => array('name', 'price'), 'filter' => array($filterA));

        $data[]     = array($query, $options, $expected->getStatement());

        return $data;
    }

    /**
     * @dataProvider expandSimpleQueryProvider
     */
    public function testExpandSimpleQuery($query, $options, $expected)
    {
        $result = Query::expandSimpleQuery($query, $options);
        $this->assertEquals($expected, $result);
    }
}
