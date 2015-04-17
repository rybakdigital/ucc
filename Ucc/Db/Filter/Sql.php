<?php

namespace Ucc\Db\Filter;

use Ucc\Data\Filter\Criterion\Criterion;
use Ucc\Data\Filter\Clause\Clause;

/**
 * Ucc\Db\Filter\Sql
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Sql
{
    public static function criterionToDirect(Criterion $criterion)
    {
        switch($criterion->op())
        {
            case 'eq':
                $op         = '=';
                $collate    = 'utf8_bin';
                break;
            case 'ne':
                $op         = '!=';
                $collate    = 'utf8_bin';
                break;
            case 'eqi':
                $op         = '=';
                $collate    = 'utf8_general_ci';
                break;
            case 'nei':
                $op         = '!=';
                $collate    = 'utf8_general_ci';
                break;
        }

        if ($op && $collate) {
            // // Are we comparing a static value or another field?
            // if (isset($criterion->value())) {
            //     $comparand = ':' . $placeHolder;
            //     // Add the static value as a parameter
            //     $clause->params[$placeHolder] = $criterion->value;
            // } elseif (isset($criterion->field2)) {
            //     $comparand = $this->getSafeFieldName(
            //             $criterion->field2, $fieldMap );
            // }

            // // Escape, quote and qualify the field name for security.
            // $field = $this->getSafeFieldName( $criterion->field, $fieldMap );

            // // Build the final clause.
            // // We can't assume the value is text, so cast it to char and
            // // use the relevant collation for the comparison.
            // // Testing shows this doesn't affect use of keys on integer
            // // fields, if they are used as part of a case sensitive filter
            // $clause->sql = $field . ' ' . $op . ' '
            //     . 'CAST(' . $comparand . ' AS CHAR)' . ' COLLATE ' . $collate;
        }
    }
}
