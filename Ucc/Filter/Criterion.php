<?php

namespace Ucc\Filter;

/**
 * Ucc\Filter\Criterion
 * Allows to represent filter criteria in sting logic format
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Criterion
{
    const CRITERION_LOGIC_INTERSCTION   = 'AND';    // Logic Intersection (AND A AND B AND C ...)
    const CRITERION_LOGIC_UNION         = 'OR';     // Logic Union (OR A OR B OR C ...)

    const CRITERION_OP_BOOL     = 'bool';   // Boolean comparison, e.g. true or false.
    const CRITERION_OP_EQ       = 'eq';     // Equals comparison (case sensitive).
    const CRITERION_OP_EQI      = 'eqi';    // Equals comparison (case insensitive).
    const CRITERION_OP_NE       = 'ne';     // Not equals comparison (case sensitive).
    const CRITERION_OP_NEI      = 'nei';    // Not equals comparison (case insensitive).
    const CRITERION_OP_LT       = 'lt';     // Less than comparison.
    const CRITERION_OP_GT       = 'gt';     // Greater than comparison.
    const CRITERION_OP_GE       = 'ge';     // Greater than or equal to comparison.
    const CRITERION_OP_LE       = 'le';     // Less than or equal to comparison.
    const CRITERION_OP_INC      = 'inc';    // Includes (case sensitive).
    const CRITERION_OP_INCI     = 'inci';   // Includes (case insensitive).
    const CRITERION_OP_NINC     = 'ninc';   // Not includes (case sensitive).
    const CRITERION_OP_NINCI    = 'ninci';  // Not includes (case insensitive).
    const CRITERION_OP_RE       = 're';     // Regular expression.
    const CRITERION_OP_BEGINS   = 'begins'; // Begins (case sensitive).
    const CRITERION_OP_BEGINSI  = 'beginsi';// Begins (case insensitive).
    const CRITERION_OP_IN       = 'in';     // Comma delimited list of values to match (case sensitive).
    const CRITERION_OP_NIN      = 'nin';    // Comma delimited list of values to not match (case sensitive).
    const CRITERION_OP_INI      = 'ini';    // Comma delimited list of values to match (case insensitive).
    const CRITERION_OP_NINI     = 'nini';   // Comma delimited list of values to not match (case insensitive).

    /**
     * Represents logic part of the criterion. Decides whether to apply "AND" (Intersection),
     * or "OR" (Union) on subsets.
     * Example:
     * array(
     *      "make"  = array("Audi", "BMW", "Honda", "Fiat", "Harley Davidson"),
     *      "cars"  = array("Audi", "BMW", "Fiat", "Honda"),
     *      "bikes" = array("Honda", "Harley Davidson")
     * )
     * {logic}-{key}-{operand}-{type}-{value} : "AND-make-eq-value-Audi"
     *
     * This tells Criterion that it is an INTERSECTION and fallowing condition is REQUIRED.
     *
     * @var     string
     */
    public $logic = self::CRITERION_LOGIC_UNION;

    /**
     * Name of the key to apply Criterion to.
     * Example:
     * array(
     *      "make"  = array("Audi", "BMW", "Honda", "Fiat", "Harley Davidson"),
     *      "cars"  = array("Audi", "BMW", "Fiat", "Honda"),
     *      "bikes" = array("Honda", "Harley Davidson")
     * )
     * {logic}-{key}-{operand}-{type}-{value} : "OR-make-eq-value-Audi"
     *
     * Available keys: "make", "cars", "bikes". Comparing on "make".
     *
     * @var     string
     */
    public $key;

    /**
     * String representation of logic operands.
     *
     * @var     string
     */
    public $operand;

    /**
     * Criterion type. This can be either "field" or "value" (more common).
     * Tells whether to use value of a given field described by the key for
     * comparison or another field.
     *
     * Example:
     * array(
     *      "make"  = array("Audi", "BMW", "Honda", "Fiat", "Harley Davidson"),
     *      "cars"  = array("Audi", "BMW", "Fiat", "Honda"),
     *      "bikes" = array("Honda", "Harley Davidson")
     * )
     * {logic}-{key}-{operand}-{type}-{value} : "OR-make-eq-value-Audi"
     * This tells Criterion that "make" value should be equal to Audi.
     *
     * {logic}-{key}-{operand}-{type}-{value} : "OR-cars-eq-field-bikes"
     * This tells Criterion that "cars" value should be equal to "bikes" value.
     *
     * @var     string
     */
    public $type;

    /**
     * Either value or the name of the filed to compare.
     */
    public $value;
}
