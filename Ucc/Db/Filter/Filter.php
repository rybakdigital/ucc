<?php

namespace Ucc\Db\Filter;

use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Exception\Data\InvalidDataException\InvalidDataValueException;
use Ucc\Data\Types\Pseudo\FilterType;
use Ucc\Data\Filter\Criterion\Criterion;
use Ucc\Db\Filter\Sql;
use Ucc\Db\Filter\Dql;
use Ucc\Data\Filter\Clause\Clause;

/**
 * Ucc\Db\Filter\Filter
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Filter
{
    /**
     * Turns Ucc\Data\Filter\Filter object (also known as criteria) into SQL
     *
     * @param Ucc\Data\Filter\Filter     $filer
     * @param array     $fieldMap   Array of field names and tables
     * @param string    $namespace  Prefix for query placeholders
     * @return Ucc\Data\Filter\Clause\Clause
     */
    public static function filterToSqlClause($filter, $fieldMap = array(), $namespace = 'filter', $collation = NULL)
    {
        // Default return values
        $sqlClause  = new Clause;
        $sql        = '';
        $params     = array();
        $criterions = $filter->getCriterions();

        foreach ($criterions as $i => $criterion) {
            // Placeholder name for query binding
            $placeHolder = $namespace . '_' . $i;

            // Turn each Criterion into Clause
            $clause = self::criterionToSqlClause($criterion, $placeHolder, $fieldMap, $collation);

            // Remove logic operand for first statement
            if (empty($sql)) {
                $clause->removeLogicFromStatement();
                $sql .= $clause->getStatement();
            } else {
                // We need to add extra space in order to separate statements
                $sql .= ' ' . $clause->getStatement();
            }

            // Add params
            $params[] = $clause->getParameters();

            $sqlClause->setParameters($clause->getParameters());
        }

        $sqlClause->setStatement($sql);

        return $sqlClause;
    }

    /**
     * Turns array of Ucc\Data\Filter\Filter objects (also known as criteria) into SQL
     *
     * @param array     $filers     Array of Ucc\Data\Filter\Filter objects
     * @param array     $fieldMap   Array of field names and tables
     * @param string    $namespace  Prefix for query placeholders
     * @return Ucc\Data\Filter\Clause\Clause
     */
    public static function filtersToSqlClause(array $filters, $fieldMap = array(), $collation = NULL)
    {
        // Default return values
        $sqlClause  = new Clause;
        $sql        = '';
        $params     = array();

        foreach ($filters as $i => $filter) {
            $clause = self::filterToSqlClause($filter, $fieldMap, $i . '_filter', $collation);

            if (!empty($sql)) {
                $sql .= ' ' . strtoupper($filter->getLogic()) . ' ';
            }

            $sql .= '(' . $clause->getStatement() . ')';

            // Add params
            $params[] = $clause->getParameters();
            $sqlClause->setParameters($clause->getParameters());
        }

        $sqlClause->setStatement($sql);

        return $sqlClause;
    }

    public static function filtersToDqlClause(array $filters, $qb)
    {
        foreach ($filters as $i => $filter) {
            self::filterToDqlClause($filter, $qb, $i . '_filter');
        }

        return $qb;
    }

    public static function filterToDqlClause($filter, $qb, $namespace = 'filter')
    {
        $expr = null;
        $cond = array();
        $andX = $qb->expr()->andX();
        $orX  = $qb->expr()->orX();

        // Get filter criterion
        $criterions = $filter->getCriterions();

        foreach ($criterions as $i => $criterion) {
            // Placeholder name for query binding
            $placeHolder = $namespace . '_' . $i;

            // Turn each Criterion into Clause
            $cond = self::criterionToDqlClause($criterion, $qb, $placeHolder);

            if ($criterion->getLogic() == 'and') {
                $andX->add($cond);
            } elseif($criterion->getLogic() == 'or') {
                $orX->add($cond);
            }
        }

        if ($filter->getLogic() == 'and') {
            $qb->andWhere($andX, $orX);
        } elseif ($filter->getLogic() == 'or') {
            $qb->orWhere($andX, $orX);
        }
    }

    /**
     * Returns Ucc\Data\Filter\Clause\Clause for successful Criterion translations, otherwise false
     *
     * @return Ucc\Data\Filter\Clause\Clause | false
     */
    public static function criterionToSqlClause(
        Criterion $criterion,
        $placeHolder = 'filter',
        $fieldMap = array(),
        $collation = NULL
    ) {
        $method = self::criterionOperandToMethod($criterion) . 'Clause';

        if (method_exists('Ucc\Db\Filter\Sql', $method)) {
            return Sql::$method($criterion, $placeHolder, $fieldMap, $collation);
        }

        return false;
    }

    /**
     * Returns Ucc\Data\Filter\Clause\Clause for successful Criterion translations, otherwise false
     *
     * @return Ucc\Data\Filter\Clause\Clause | false
     */
    public static function criterionToDqlClause(Criterion $criterion, $qb, $placeHolder = 'filter')
    {
        $method = self::criterionOperandToMethod($criterion) . 'Clause';

        if (method_exists('Ucc\Db\Filter\Dql', $method)) {
            return Dql::$method($criterion, $qb, $placeHolder);
        }

        return false;
    }

    /**
     * Decides which transformation method use for given operand
     *
     * @param   Criterion   $criterion
     * @return  string | false      Return method name or false if method can not be determined
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

            default:
                $method = false;
        }

        return $method;
    }
}
