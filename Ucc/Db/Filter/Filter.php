<?php

namespace Ucc\Db\Filter;

use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataException\InvalidDataValueException;
use Ucc\Data\Types\Pseudo\FilterType;
use Ucc\Data\Filter\Criterion\Criterion;
use Ucc\Db\Filter\Sql;

/**
 * Ucc\Db\Filter\Filter
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Filter
{
    /**
     * Turns array of Ucc\Data\Filter\Filter objects (also known as criteria) into SQL
     *
     * @param array     $criteria   Array of Ucc\Data\Filter\Filter objects
     * @param array     $fieldMap   Array of field names and tables
     * @param string    $namespace  Prefix for query placeholders
     */
    public static function filterToSql($criteria = array(), $fieldMap = array(), $namespace = 'filter')
    {
        // Default return values
        $sql    = '';
        $params = array();

        if (!is_array($criteria)) {
            $error = 'criteria must be an array of Criterion objects or list of filters (string type) in a format: {logic}-{field}-{operand}-{type}-{value}';

            throw new InvalidDataTypeException($error);
        }

        foreach ($criteria as $i => $criterion) {
            if (is_string($criterion)) {
                $criterion = FilterType::filterToCriterion($criterion);
            }

            if (!is_a($criterion, 'Ucc\Data\Filter\Criterion\Criterion')) {
                $error = 'value for index ' . $i . ' of criteria must be of Ucc\Data\Filter\Criterion\Criterion type';

                throw new InvalidDataTypeException($error);
            }

            // Placeholder name for query binding
            $placeHolder = $namespace . '_' . $i;

            $filter = self::criterionToSQL($criterion, $placeHolder, $fieldMap);

            $sql .= $filter->getStatement();
        }
    }

    /**
     * Returns Ucc\Data\Filter\Clause\Clause for successful Criterion translations, otherwise false
     *
     * @return Ucc\Data\Filter\Clause\Clause | false
     */
    public static function criterionToSqlClause(Criterion $criterion, $placeHolder = 'filter', $fieldMap = array())
    {
        $method = self::criterionOperandToMethod($criterion) . 'Clause';

        if (method_exists('Ucc\Db\Filter\Sql', $method)) {
            return Sql::$method($criterion, $placeHolder, $fieldMap);
        }

        return false;
    }

    /**
     * Decides which transformation method use for given operand
     *
     * @param   Criterion   $criterion
     * @return  string
     */
    public static function criterionOperandToMethod(Criterion $criterion)
    {
        switch ($criterion->op())
        {
            // Boolean check to see if the value is set or not.
            case 'bool':
                $method = 'criterionToBool';
                break;

            // Direct comparison checks.
            case 'eq': // equals
            case 'ne': // does not equal
            case 'eqi': // equals (case insensitive)
            case 'nei': // does not equal (case insensitive)
                $method = 'criterionToDirect';
                break;

            // Relative comparison checks.
            case 'gt': // greater than
            case 'ge': // greater than or equal to
            case 'lt': // less than
            case 'le': // less than or equal to
                $method = 'criterionToRelative';
                break;

            // Wildcard comparison checks (contains/includes)
            case 'inc': // includes
            case 'ninc': // does not include
            case 'inci': // includes (case insensitive)
            case 'ninci': // does not include (case insensitive)
                $method = 'criterionToContains';
                break;

            // Wildcard comparison checks (begins with)
            case 'begins': // begins with
            case 'nbegins': // does not begin with
            case 'beginsi': // begins with (case insensitive)
            case 'nbeginsi': // does not begin with (case insensitive)
                $method = 'criterionToBegins';
                break;

            // Regex match
            case 're': // matches regex string
                $method = 'criterionToRegex';
                break;

            // Check for a list of values (match or no match).
            case 'in': // is in the list
            case 'nin': // is not in the list
            case 'ini': // is in the list (case insensitive)
            case 'nini': // is not in the list (case insensitive)
                $method = 'criterionToIn';
                break;
        }

        return $method;
    }
}
