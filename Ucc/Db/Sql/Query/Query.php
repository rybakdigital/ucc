<?php

namespace Ucc\Db\Sql\Query;

use Ucc\Data\Filter\Clause\Clause;
use Ucc\Db\Filter\Sql;

/**
 * Ucc\Db\Sql\Query\Query
 * Compiled SQL query.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Query extends Clause
{
    public static $defaultOptions = array('filter', 'group', 'sort');

    /**
     * Expands simple SQL query. 
     */
    public static function expandSimpleQuery(Query $query, $options = array(), $fieldMap = array())
    {
        // Get SQL statement, we will work arround it
        // Remove white space from SQL
        $sql = trim($query->getStatement());

        $clauses = array();

        foreach (self::$defaultOptions as $option) {
            if (!empty($options[$option])) {
                $optionSettings = $options[$option];
            } else {
                $optionSettings = array();
            }

            $method = 'get' . ucfirst($option) . 'Sql';
            $clauses[$option] = SQL::$method($optionSettings, $fieldMap);
        }

        if (!empty($clauses['filter']['where'])) {
            $sql .= ' ' . $clauses['filter']['where'];
        }

        if (!empty($clauses['group'])) {
            $sql .= ' ' . $clauses['group'];
        }

        if (!empty($clauses['sort'])) {
            $sql .= ' ' . $clauses['sort'];
        }

        return $sql;
    }
}
