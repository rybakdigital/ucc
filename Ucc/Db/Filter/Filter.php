<?php

namespace Ucc\Db\Filter;

use Ucc\Exception\Data\InvalidDataTypeException;
use Ucc\Data\Types\Pseudo\FilterType;
use Ucc\Data\Filter\Criterion\Criterion;

/**
 * Ucc\Db\Filter\Filter
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Filter
{
    public static function criteriaToDQL($criteria = array())
    {
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

            $filter = self::criterionToDQL($criterion);
        }
    }

    public static function criterionToDQL(Criterion $criterion)
    {
            switch ($criterion->op())
            {
                // Boolean check to see if the value is set or not.
                case 'bool':
                    $method = 'criterionToDQLBool';
                    break;

                // Direct comparison checks.
                case 'eq': // equals
                case 'ne': // does not equal
                case 'eqi': // equals (case insensitive)
                case 'nei': // does not equal (case insensitive)
                    $method = 'criterionToDQLEq';
                    break;

                // Relative comparison checks.
                case 'gt': // greater than
                case 'ge': // greater than or equal to
                case 'lt': // less than
                case 'le': // less than or equal to
                    $method = 'criterionToDQLGt';
                    break;

                // Percentage comparison checks.
                case 'gtp': // greater than % of
                case 'gep': // greater than or equal to % of
                case 'ltp': // less than % of
                case 'lep': // less than or equal to % of
                    $method = 'criterionToDQLGtp';
                    break;

                // Wildcard comparison checks (contains/includes)
                case 'inc': // includes
                case 'ninc': // does not include
                case 'inci': // includes (case insensitive)
                case 'ninci': // does not include (case insensitive)
                    $method = 'criterionToDQLInc';
                    break;

                // Wildcard comparison checks (begins with)
                case 'begins': // begins with
                case 'nbegins': // does not begin with
                case 'beginsi': // begins with (case insensitive)
                case 'nbeginsi': // does not begin with (case insensitive)
                    $method = 'criterionToDQLBegins';
                    break;

                // Regex match
                case 're': // matches regex string
                    $method = 'criterionToDQLRe';
                    break;

                // Check for a list of values (match or no match).
                case 'in': // is in the list
                case 'nin': // is not in the list
                case 'ini': // is in the list (case insensitive)
                case 'nini': // is not in the list (case insensitive)
                    $method = 'criterionToDQLIn';
                    break;
            }

            // Methods modify the $clause object so no return value required.
            // Note no default method - keep default return values if the
            // method is invalid or unrecognised.
            if ( method_exists( $this, $method ) )
            {
                $this->$method( $clause, $criterion, $placeHolder, $fieldMap );
            }
    }
}
