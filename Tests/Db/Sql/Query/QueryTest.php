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
        $expectedParams = array(
            '0_filter_0' => 'galaxy',
            '0_filter_1' => '4s',
            '0_filter_2' => '100',
        );
        $query
            ->setStatement($sql);

        $expected   = new Query;
        $expected
            ->setStatement($expectedSql)
            ->setParameters($expectedParams);

        $sort1 = new Sort;
        $sort1->setField('name');
        $sort2 = new Sort;
        $sort2->setField('price')->setDirection('DESC');

        $filterA     = new Filter();
        $criterions = array(
            FilterType::criteriaToCriterion('and-name-inci-value-galaxy'),
            FilterType::criteriaToCriterion('or-name-inci-value-4s'),
            FilterType::criteriaToCriterion('and-price-gt-value-100'),
        );
        $filterA->setCriterions($criterions);
        $options = array('sort' => array($sort1, $sort2), 'group' => array('name', 'price'), 'filter' => array($filterA));

        $data[]     = array($query, $options, $expected);

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
            FilterType::criteriaToCriterion('and-name-eq-field-price'),
            FilterType::criteriaToCriterion('or-clicks-gt-field-price')
        );
        $filterA->setCriterions($criterions);

        $options = array('filter' => array($filterA));
        $data[]  = array($query, $options, $expected, $fieldMap);

        // test * in field map
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
            FilterType::criteriaToCriterion('and-name-eq-field-price'),
            FilterType::criteriaToCriterion('or-clicks-gt-field-price')
        );
        $filterA->setCriterions($criterions);

        $options = array('filter' => array($filterA));
        $data[]  = array($query, $options, $expected, $fieldMap);

        // test LIMIT and offset
        $query      = new Query;
        $query->setStatement($sql);
        $sql        = 'SELECT * FROM `products` ';
        $expectedSql = 'SELECT * FROM `products` WHERE (`name` = CAST(`price` AS CHAR) COLLATE utf8_bin OR `clicks` > `price`) LIMIT 10,20';
        $expected   = new Query;
        $expected
            ->setStatement($expectedSql);
        $filterA    = new Filter();
        $criterions = array(
            FilterType::criteriaToCriterion('and-name-eq-field-price'),
            FilterType::criteriaToCriterion('or-clicks-gt-field-price')
        );
        $filterA->setCriterions($criterions);

        $options = array('filter' => array($filterA), 'limit' => 20, 'offset' => 10);
        $data[]  = array($query, $options, $expected);

        // test Single Filter
        $sql            = 'SELECT * FROM `orders` ';
        $querySingle    = new Query;
        $querySingle->setStatement($sql);

        $expectedSql = 'SELECT * FROM `orders` WHERE (`id` > :0_filter_0 AND `id` >= :0_filter_1) LIMIT 2,100';
        $expectedParams = array(
            '0_filter_0' => '1',
            '0_filter_1' => '2',
        );

        $expected   = new Query;
        $expected
            ->setStatement($expectedSql)
            ->setParameters($expectedParams);

        $filterSingle    = new Filter();
        $criterions = array(
            FilterType::criteriaToCriterion('and-id-gt-value-1'),
            FilterType::criteriaToCriterion('and-id-ge-value-2')
        );
        $filterSingle->setCriterions($criterions);

        $options = array('filter' => $filterSingle, 'limit' => 100, 'offset' => 2);
        $data[]  = array($querySingle, $options, $expected);

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
