<?php

namespace Ucc\Db\Filter;

use Ucc\Data\Filter\Criterion\Criterion;
use Ucc\Data\Filter\Clause\Clause;
use Ucc\Data\Sortable\Sort\Sort;
use Ucc\Data\Filter\Filter as Data_Filter;
use \InvalidArgumentException;

/**
 * Ucc\Db\Filter\Sql
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Sql
{
    public const COLLATION_UTF8_BIN             = 'utf8_bin';
    public const COLLATION_UTF8_GENERAL_CI      = 'utf8_general_ci';
    public const COLLATION_UTF8MB4_BIN          = 'utf8mb4_bin';
    public const COLLATION_UTF8MB4_GENERAL_CI   = 'utf8mb4_general_ci';

    public const COLLATION_TYPE_UTF8            = 'utf8';
    public const COLLATION_TYPE_UTF8MB4         = 'utf8mb4';

    public const COLLATION_TYPE_CHARSET_BIN     = 'bin';
    public const COLLATION_TYPE_CHARSET_CI      = 'general_ci';

    /**
     * Turns Criterion into Sql Clause
     */
    public static function criterionToBoolClause(Criterion $criterion, $placeHolder = 'filter_0', $fieldMap = array())
    {
        // Escape, quote and qualify the field name for security.
        $field  = self::getSafeFieldName($criterion->key(), $fieldMap);
        $clause = new Clause;

        // We can only compare true or false for boolean
        if (
            (strtolower($criterion->value()) == 'true') ||
            ($criterion->value() == 1)
            ) {
            $clause->setStatement(self::addLogic($criterion) . ' (' . $field . ' IS NOT NULL AND ' . $field . ' != "")');
        } elseif (
            (strtolower($criterion->value()) == 'false') ||
            ($criterion->value() == 0)
            ) {
            $clause->setStatement(self::addLogic($criterion) . ' (' . $field . ' IS NULL OR ' . $field . ' = "")');
        }

        return $clause;
    }

    /**
     * Turns Criterion into Direct Sql Clause
     *
     * @param   Criterion   $criterion      Criterion to process
     * @param   string      $placeHolder    Placeholder for parameter name
     * @param   array       $fieldMap       Array representing field map
     * @param   string      $collationType  Collation type. Either utf8 or utf8mb4. Default: utf8
     */
    public static function criterionToDirectClause(
        Criterion $criterion,
        $placeHolder = 'filter_0',
        $fieldMap = array(),
        $collationType = self::COLLATION_TYPE_UTF8
    ) {
        // Create local operand and collate
        $op         = false;
        $collate    = false;
        $clause     = new Clause;

        switch($criterion->op())
        {
            case 'eq':
                $op         = '=';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_BIN, $collationType);
                break;
            case 'ne':
                $op         = '!=';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_BIN, $collationType);
                break;
            case 'eqi':
                $op         = '=';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_CI, $collationType);
                break;
            case 'nei':
                $op         = '!=';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_CI, $collationType);
                break;
        }

        if ($op && $collate) {
            if ($criterion->type() == Criterion::CRITERION_TYPE_VALUE) {
                $comparand = ':' . $placeHolder;
                // Add the static value as a parameter
                $clause->setParameter($placeHolder, $criterion->value());
            } elseif ($criterion->type() == Criterion::CRITERION_TYPE_FIELD) {
                $comparand = self::getSafeFieldName($criterion->value(), $fieldMap);
            }

            // Escape, quote and qualify the field name for security.
            $field = self::getSafeFieldName($criterion->key(), $fieldMap);

            // Build the final clause.
            // We can't assume the value is text, so cast it to char and
            // use the relevant collation for the comparison.
            // Testing shows this doesn't affect use of keys on integer
            // fields, if they are used as part of a case sensitive filter
            $clause->setStatement(self::addLogic($criterion) . ' ' . $field . ' ' . $op . ' '
                . 'CAST(' . $comparand . ' AS CHAR)' . ' COLLATE ' . $collate);
        }

        return $clause;
    }

    /**
     * Turns Criterion into Relative Sql Clause
     *
     * @param   Criterion   $criterion      Criterion to process
     * @param   string      $placeHolder    Placeholder for parameter name
     * @param   array       $fieldMap       Array representing field map
     */
    public static function criterionToRelativeClause(Criterion $criterion, $placeHolder = 'filter_0', $fieldMap = array())
    {
        // Create local operand
        $op         = false;
        $clause     = new Clause;

        switch($criterion->op())
        {
            case 'gt':
                $op         = '>';
                break;
            case 'ge':
                $op         = '>=';
                break;
            case 'lt':
                $op         = '<';
                break;
            case 'le':
                $op         = '<=';
                break;
        }

        if ($op) {
            if ($criterion->type() == Criterion::CRITERION_TYPE_VALUE) {
                $comparand = ':' . $placeHolder;
                // Add the static value as a parameter
                $clause->setParameter($placeHolder, $criterion->value());
            } elseif ($criterion->type() == Criterion::CRITERION_TYPE_FIELD) {
                $comparand = self::getSafeFieldName($criterion->value(), $fieldMap);
            }

            // Escape, quote and qualify the field name for security.
            $field = self::getSafeFieldName($criterion->key(), $fieldMap);

            // Build the final clause.
            $clause->setStatement(self::addLogic($criterion) . ' ' .$field . ' ' . $op . ' ' . $comparand);
        }

        return $clause;
    }

    /**
     * Turns Criterion into Contains Sql Clause
     *
     * @param   Criterion   $criterion      Criterion to process
     * @param   string      $placeHolder    Placeholder for parameter name
     * @param   array       $fieldMap       Array representing field map
     * @param   string      $collationType  Collation type. Either utf8 or utf8mb4. Default: utf8
     */
    public static function criterionToContainsClause(
        Criterion $criterion,
        $placeHolder = 'filter_0',
        $fieldMap = array(),
        $collationType = self::COLLATION_TYPE_UTF8
    ) {
        // Create local operand and collate
        $op         = false;
        $collate    = false;
        $clause     = new Clause;

        switch($criterion->op())
        {
            case 'inc': // includes
                $op         = 'LIKE';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_BIN, $collationType);
                break;
            case 'ninc': // does not include
                $op         = 'NOT LIKE';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_BIN, $collationType);
                break;
            case 'inci': // includes (case insensitive)
                $op         = 'LIKE';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_CI, $collationType);
                break;
            case 'ninci': // does not include (case insensitive)
                $op         = 'NOT LIKE';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_CI, $collationType);
                break;
        }

        if ($op && $collate) {
            if ($criterion->type() == Criterion::CRITERION_TYPE_VALUE) {
                $comparand = ':' . $placeHolder;
                // Add the static value as a parameter
                $clause->setParameter($placeHolder, $criterion->value());
            } elseif ($criterion->type() == Criterion::CRITERION_TYPE_FIELD) {
                $comparand = self::getSafeFieldName($criterion->value(), $fieldMap);
            }

            // Escape, quote and qualify the field name for security.
            $field = self::getSafeFieldName($criterion->key(), $fieldMap);

            // Build the final clause.
            // Use wild-card characters for "contains".
            $clause->setStatement(self::addLogic($criterion) . ' ' . $field . ' ' . $op . ' '
                    . 'CONCAT("%", ' . $comparand . ', "%")'
                    . ' COLLATE ' . $collate);
        }

        return $clause;
    }

    /**
     * Turns Criterion into Begins with Sql Clause
     *
     * @param   Criterion   $criterion      Criterion to process
     * @param   string      $placeHolder    Placeholder for parameter name
     * @param   array       $fieldMap       Array representing field map
     * @param   string      $collationType  Collation type. Either utf8 or utf8mb4. Default: utf8
     */
    public static function criterionToBeginsClause(
        Criterion $criterion,
        $placeHolder = 'filter_0',
        $fieldMap = array(),
        $collationType = self::COLLATION_TYPE_UTF8
    ) {
        // Create local operand and collate
        $op         = false;
        $collate    = false;
        $clause     = new Clause;

        switch($criterion->op())
        {
            case 'begins': // begins with
                $op         = 'LIKE';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_BIN, $collationType);
                break;
            case 'nbegins': // does not begin with
                $op         = 'NOT LIKE';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_BIN, $collationType);
                break;
            case 'beginsi': // begins with (case insensitive)
                $op         = 'LIKE';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_CI, $collationType);
                break;
            case 'nbeginsi': // does not begin with (case insensitive)
                $op         = 'NOT LIKE';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_CI, $collationType);
                break;
        }

        if ($op && $collate) {
            if ($criterion->type() == Criterion::CRITERION_TYPE_VALUE) {
                $comparand = ':' . $placeHolder;
                // Add the static value as a parameter
                $clause->setParameter($placeHolder, $criterion->value());
            } elseif ($criterion->type() == Criterion::CRITERION_TYPE_FIELD) {
                $comparand = self::getSafeFieldName($criterion->value(), $fieldMap);
            }

            // Escape, quote and qualify the field name for security.
            $field = self::getSafeFieldName($criterion->key(), $fieldMap);

            // Build the final clause.
            // Use end wild-card character for "begins with".
            $clause->setStatement(self::addLogic($criterion) . ' ' . $field . ' ' . $op . ' '
                    . 'CONCAT(' . $comparand . ', "%")'
                    . ' COLLATE ' . $collate);
        }

        return $clause;
    }

    /**
     * Turns Criterion into Regular expression Sql Clause
     *
     * @param   Criterion   $criterion      Criterion to process
     * @param   string      $placeHolder    Placeholder for parameter name
     * @param   array       $fieldMap       Array representing field map
     */
    public static function criterionToRegexClause(Criterion $criterion, $placeHolder = 'filter_0', $fieldMap = array())
    {
        $clause = new Clause;

        if ($criterion->type() == Criterion::CRITERION_TYPE_VALUE) {
            $comparand = ':' . $placeHolder;
            // Add the static value as a parameter
            $clause->setParameter($placeHolder, $criterion->value());
        } elseif ($criterion->type() == Criterion::CRITERION_TYPE_FIELD) {
            $comparand = self::getSafeFieldName($criterion->value(), $fieldMap);
        }

        // Escape, quote and qualify the field name for security.
        $field = self::getSafeFieldName($criterion->key(), $fieldMap);

        // Build the final clause.
        // Use end wild-card character for "begins with".
        $clause->setStatement(self::addLogic($criterion) . ' ' . $field . ' REGEXP ' . $comparand);

        return $clause;
    }

    /**
     * Turns Criterion into IN Sql Clause
     *
     * @param   Criterion   $criterion      Criterion to process
     * @param   string      $placeHolder    Placeholder for parameter name
     * @param   array       $fieldMap       Array representing field map
     * @param   string      $collationType  Collation type. Either utf8 or utf8mb4. Default: utf8
     */
    public static function criterionToInClause(
        Criterion $criterion,
        $placeHolder = 'filter_0',
        $fieldMap = array(),
        $collationType = self::COLLATION_TYPE_UTF8
    ) {
        // Create local operand and collate
        $op         = false;
        $collate    = false;
        $clause     = new Clause;

        switch($criterion->op())
        {
            case 'in':
                $op         = 'IN';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_BIN, $collationType);
                break;
            case 'nin':
                $op         = 'NOT IN';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_BIN, $collationType);
                break;
            case 'ini':
                $op         = 'IN';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_CI, $collationType);
                break;
            case 'nini':
                $op         = 'NOT IN';
                $collate    = self::getCollationCharset(self::COLLATION_TYPE_CHARSET_CI, $collationType);
                break;
        }

        if ($op && $collate) {
            if ($criterion->type() == Criterion::CRITERION_TYPE_VALUE) {
                // Values should be in a comma separated list.
                $values = explode(',', $criterion->value());

                // We must add a parameter and a placeholder for each value.
                $placeHolders = array();
                foreach ($values as $key => $value)
                {
                    $clause->setParameter($placeHolder . '_' . $key, $value);
                    $placeHolders[] = ':' . $placeHolder . '_' . $key
                        . ' COLLATE ' . $collate;
                }

                // The comparand for this operation is the list of values.
                $comparand = '(' . implode(', ', $placeHolders) . ')';
            } elseif ($criterion->type() == Criterion::CRITERION_TYPE_FIELD) {
                // Field names should be in a comma separated list.
                $fList = explode(',', $criterion->value());

                foreach (array_keys($fList) as $key) {
                    $fList[$key] = self::getSafeFieldName(
                            $fList[$key], $fieldMap)
                            . ' COLLATE ' . $collate;
                }

                // The comparand for this operation is the list of field names.
                $comparand = '(' . implode(', ', $fList) . ')';
            }

            // Escape, quote and qualify the field name for security.
            $field = self::getSafeFieldName($criterion->key(), $fieldMap);

            // Build the final clause.
            // Use end wild-card character for "begins with".
            $clause->setStatement(self::addLogic($criterion) . ' ' .  $field . ' ' . $op . ' ' . $comparand);
        }

        return $clause;
    }

    /**
     * Gets Criterion logic and returns it in CAPITALIZED string
     * @param   Criterion
     * @return  string      Criterion logic
     */
    public static function addLogic(Criterion $criterion)
    {
        return strtoupper($criterion->logic());
    }

    /**
     * Escape a SQL string for use with MySQL
     *
     * We can't use mysql_real_escape_string since it needs a database
     * connection resource from mysql_connect. This functionality is being
     * replicated here.
     *
     * @param   string  $string Unescaped string
     * @return  mixed   Escaped string, false on failure
     */
    public static function escape($string) {
        if (is_string($string)) {
            return str_replace(
                    array('\\', "\0", "\n", "\r", "'", '"', "\x1a"),
                    array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'),
                    $string);
        }

        return false;
    }

    /**
     * Escape a SQL string for use with MySQL
     *
     * @param   string  $string Unquoted string
     * @return  mixed   Quoted string, false on failure
     */
    public static function quote($string)
    {
        if (is_string($string)) {
            return  str_replace('.', '`.`', '`' . str_replace('`', '', $string) . '`');
        }

        return false;
    }

    /**
     * This method returns a safe string to use in a query when referring to a
     * field. It uses a field map array to decide which table a field refers to.
     * If you don't want the table name prepended then use an empty field map.
     *
     * @param   string  $filed      The field you want to find the safe string for.
     * @param   array   $filedMap   Field map (optional).
     * @return  mixed               Escaped and Quoted `table`.`field` name or false on failure.
     */
    public static function getSafeFieldName($field, array $fieldMap = NULL)
    {
        // Start by escaping and quoting the field name.
        $ret = self::quote(self::escape($field));

        // If the field map is populated we can look for a table name.
        if (!empty($fieldMap)) {
            $table = self::getSafeTableName($field, $fieldMap);

            // Prepend the table name if it's not empty.
            if (!empty($table)) {
                // Check if field was already prepended with table name
                $parts = explode('.', $ret);

                if (count($parts) > 1) {
                    $fieldName = end($parts);
                } else {
                    $fieldName = $parts[0];
                }

                $ret = $table . '.' . $fieldName;
            }
        }

        return $ret;
    }

    /**
     * This method returns a safe string to use in a query when referring to a
     * table. It uses a field map array to decide which table a field refers to.
     *
     * @param   string Field you want to find out what table it belongs to.
     * @param   array Field map.
     * @return  mixed Escaped and Quoted table name or false on failure.
     */
    public static function getSafeTableName($field, array $fieldMap)
    {
        if (is_string($field)) {
            // Find the correct table for this field according to the field map.

            if(isset($fieldMap[$field])) {
                $table = $fieldMap[ $field ];
            } elseif (isset($fieldMap['*'])) {
                $table = $fieldMap['*'];
            } else {
                $table = '';
            }

            // Ignore 'having' table as it doesn't really exist.
            if ('having' === $table) {
                $table = '';
            }

            // Escape and quote the table name for security.
            if (!empty($table)) {
                $table = self::quote(self::escape($table));
            }

            return $table;
        }

        return false;
    }

    /**
     * Builds SQL from filters (WHERE or HAVING parts)
     *
     * @param array     $filters        Array of Ucc\Data\Filter\Filter objects
     * @param array     $fieldMap       Array representing filed map
     * @param boolean   $singleTable    Marker to indicate single table queries.
     * @return  string
     */
    public static function getFilterSql($filters = array(), $fieldMap = array(), $singleTable = false, $collation = NULL)
    {
        $ret            = array('paramiters' => array());
        $havingFilters  = array();
        $whereFilters   = array();
        $table          = '';

        // Check if filters is a single filter
        if (is_a($filters, 'Ucc\Data\Filter\Filter')) {
            $filters = array($filters);
        }

        foreach ($filters as $i => $filter) {
            // get Criterions
            $criterions     = $filter->getCriterions();
            $havingFilter   = new Data_Filter();
            $whereFilter    = new Data_Filter();

            foreach ($criterions as $criterion) {
                if (isset($fieldMap[$criterion->key()])) {
                    // Get table name from field map
                    $table = $fieldMap[$criterion->key()];

                // Check for wildecard
                } elseif (isset($fieldMap['*'])) {
                    $table = $fieldMap['*'];
                }

                if (!$singleTable || $singleTable === $table) {
                    // Allow pseudo tables 'HAVING'
                    if ($table == 'having') {
                        $havingFilter->addCriterion($criterion);
                    } else {
                        $whereFilter->addCriterion($criterion);
                    }
                }
            }

            $havingCriterions = $havingFilter->getCriterions();

            if (!empty($havingCriterions)) {
                $havingFilters[$i . '_h']  = $havingFilter;
            }

            $whereFilters[$i . '_w']   = $whereFilter;
        }

        $where  = Filter::filtersToSqlClause($whereFilters, $fieldMap, $collation);
        $having = Filter::filtersToSqlClause($havingFilters, $fieldMap, $collation);

        $whereStatemet      = $where->getStatement();
        $havingStatement    = $having->getStatement();

        if (!empty($whereStatemet) && $whereStatemet != '()') {
            $ret['where'] = 'WHERE ' . $whereStatemet;
            $ret['paramiters'] = array_merge($ret['paramiters'], $where->getParameters());
        }

        if (!empty($havingStatement)) {
            $ret['having'] = 'HAVING ' . $havingStatement;
            $ret['paramiters'] = array_merge($ret['paramiters'], $having->getParameters());
        }

        return $ret;
    }

    /**
     * Returns GROUP part of SQL statement
     *
     * @param   array   $groups     Array of groups to use
     * @param   array   $fieldMap   Array representing filed map
     * @return  string
     */
    public static function getGroupSql($groups = array(), $fieldMap = array())
    {
        $ret = '';

        // Generate custom group statements
        if(is_array($groups) && !empty($groups)) {
            foreach($groups as $group) {
                $field = self::getSafeFieldName($group, $fieldMap);
                $ret .= $field . ',';
            }

            return 'GROUP BY ' . rtrim($ret, ',');
        }

        return $ret;
    }

    /**
     * Returns ORDER BY part of SQL statement
     *
     * @param   array   $sorts      Array of sorts
     * @param   array   $fieldMap   Array representing filed map
     * @return  string
     */
    public static function getSortSql($sorts = array(), $fieldMap = array())
    {
        $ret = '';

        foreach ($sorts as $sort) {
            if (!is_a($sort, 'Ucc\Data\Sortable\Sort\SortInterface')) {
                throw new InvalidArgumentException("Sort must implement Ucc\Data\Sortable\Sort\SortInterface");
            }

            // Escape, quote and qualify the field name.
            $field = self::getSafeFieldName($sort->field(), $fieldMap);

            $ret .= $field . ' ' . strtoupper($sort->direction()) . ',';
        }

        if (!empty($ret)) {
            return 'ORDER BY ' . rtrim($ret, ',');
        }

        return $ret;
    }

    /**
     * Gets LIMIT part of the SQL statement
     * @param integer   $limit
     * @param integer   $offset
     */
    public static function getLimitSql($limit = NULL, $offset = NULL)
    {
        $ret = '';

        // Convert to numbers
        $limit  = intval($limit);
        $offset = intval($offset);

        if (($limit > 0) && ($offset >= 0)) {
            return 'LIMIT ' . $offset  . ',' . $limit;
        }

        return $ret;
    }

    /**
     * Get collation based on db collation type
     *
     * @param string $charSet   Preferred char set
     * @param string $type      Database collation type
     * @return string Collation charset
     */
    public static function getCollationCharset(string $charSet, string $type = NULL)
    {
        switch ($charSet) {
            case self::COLLATION_TYPE_CHARSET_BIN:
                if ($type == self::COLLATION_TYPE_UTF8MB4) {
                    return self::COLLATION_UTF8MB4_BIN;
                }

                return self::COLLATION_UTF8_BIN;
                break;

            case self::COLLATION_TYPE_CHARSET_CI:
                if ($type == self::COLLATION_TYPE_UTF8MB4) {
                    return self::COLLATION_UTF8MB4_GENERAL_CI;
                }

                return self::COLLATION_UTF8_GENERAL_CI;
                break;

            default:
                return self::COLLATION_UTF8_BIN;
                break;
        }
    }
}
