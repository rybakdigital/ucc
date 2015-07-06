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
        // test WHERE and SORT
        $data       = array();
        $options    = array();

        $query      = new Query;
        $sql        = 'SELECT * FROM `products` ';
        $expectedSql = 'SELECT * FROM `products` WHERE (`name` LIKE CONCAT("%", :0_filter_0, "%") COLLATE utf8_general_ci OR `name` LIKE CONCAT("%", :0_filter_1, "%") COLLATE utf8_general_ci AND `price` > :0_filter_2) GROUP BY `name`,`price` ORDER BY `name` ASC,`price` DESC';
        $query
            ->setStatement($sql);
        $expected   = new Query;
        $expected
            ->setStatement($expectedSql);

        $sort1 = new Sort;
        $sort1->setField('name');
        $sort2 = new Sort;
        $sort2->setField('price')->setDirection('DESC');

        $filterA     = new Filter();
        $criterions = array(
            FilterType::filterToCriterion('and-name-inci-value-galaxy'),
            FilterType::filterToCriterion('or-name-inci-value-4s'),
            FilterType::filterToCriterion('and-price-gt-value-100'),
        );
        $filterA->setCriterions($criterions);
        $options = array('sort' => array($sort1, $sort2), 'group' => array('name', 'price'), 'filter' => array($filterA));

        $data[]     = array($query, $options, $expected->getStatement());

        // test HAVING
        $query      = new Query;
        $query->setStatement($sql);
        $sql        = 'SELECT * FROM `products` ';
        $expectedSql = 'SELECT * FROM `products` HAVING (`name` = CAST(`price` AS CHAR) COLLATE utf8_bin OR `clicks` > `price`)';
        $expected   = new Query;
        $expected
            ->setStatement($expectedSql);
        $fieldMap   = array( 'name' => 'having' );
        $filterA    = new Filter();
        $criterions = array(
            FilterType::filterToCriterion('and-name-eq-field-price'),
            FilterType::filterToCriterion('or-clicks-gt-field-price')
        );
        $filterA->setCriterions($criterions);

        $options = array('filter' => array($filterA));
        $data[]  = array($query, $options, $expected->getStatement(), $fieldMap);

        // test HAVING
        $query      = new Query;
        $query->setStatement($sql);
        $sql        = 'SELECT * FROM `products` ';
        $expectedSql = 'SELECT * FROM `products` HAVING (`name` = CAST(`price` AS CHAR) COLLATE utf8_bin OR `clicks` > `price`)';
        $expected   = new Query;
        $expected
            ->setStatement($expectedSql);
        $fieldMap   = array( '*' => 'having' );
        $filterA    = new Filter();
        $criterions = array(
            FilterType::filterToCriterion('and-name-eq-field-price'),
            FilterType::filterToCriterion('or-clicks-gt-field-price')
        );
        $filterA->setCriterions($criterions);

        $options = array('filter' => array($filterA));
        $data[]  = array($query, $options, $expected->getStatement(), $fieldMap);

        return $data;
    }

    /**
     * @dataProvider expandSimpleQueryProvider
     */
    public function testExpandSimpleQuery($query, $options, $expected, $fieldMap = array())
    {
        $result = Query::expandSimpleQuery($query, $options, $fieldMap);
        $this->assertEquals($expected, $result);
    }
}
