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
     * Expands simple SQL query. Adds filter, group, sort, limit and offset to existing query.
     *
     * @param   Ucc\Db\Sql\Query    $query      Instance of the Query to expand. This must be a simple
     *                                          query to work.
     * @param   array               $options    Array of options to pass to query.
     * @param   array               $fieldMap   Field map to use when building the query.
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

        if (!empty($clauses['filter']['having'])) {
            $sql .= ' ' . $clauses['filter']['having'];
        }

        if (!empty($clauses['sort'])) {
            $sql .= ' ' . $clauses['sort'];
        }

        return $sql;
    }
}
