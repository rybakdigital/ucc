<?php

namespace Ucc\Filter\Criterion;

use \InvalidArgumentException;
use Ucc\Filter\Criterion\CriterionInterface;

/**
 * Ucc\Filter\Criterion\Criterion
 * Allows to represent filter criteria in sting logic format
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Criterion implements CriterionInterface
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
    const CRITERION_OP_INI      = 'ini';    // Comma delimited list of values to match (case insensitive).
    const CRITERION_OP_NIN      = 'nin';    // Comma delimited list of values to not match (case sensitive).
    const CRITERION_OP_NINI     = 'nini';   // Comma delimited list of values to not match (case insensitive).

    const CRITERION_TYPE_FIELD  = 'field';  // Field type comparison
    const CRITERION_TYPE_VALUE  = 'value';  // Value type comparison

    public static $criterionLogic = array(
        self::CRITERION_LOGIC_INTERSCTION,
        self::CRITERION_LOGIC_UNION,
    );

    public static $criterionOperands = array(
        self::CRITERION_OP_BOOL,
        self::CRITERION_OP_EQ,
        self::CRITERION_OP_EQI,
        self::CRITERION_OP_NE,
        self::CRITERION_OP_NEI,
        self::CRITERION_OP_LT,
        self::CRITERION_OP_GT,
        self::CRITERION_OP_GE,
        self::CRITERION_OP_LE,
        self::CRITERION_OP_INC,
        self::CRITERION_OP_INCI,
        self::CRITERION_OP_NINC,
        self::CRITERION_OP_NINCI,
        self::CRITERION_OP_RE,
        self::CRITERION_OP_BEGINS,
        self::CRITERION_OP_BEGINSI,
        self::CRITERION_OP_IN,
        self::CRITERION_OP_INI,
        self::CRITERION_OP_NIN,
        self::CRITERION_OP_NINI,
    );

    public static $operandTexts = array(
        'bool'      => 'is',
        'eq'        => 'is equal (case sensitive) to',
        'eqi'       => 'is equal (case insensitive) to',
        'ne'        => 'is NOT equal (case sensitive) to',
        'nei'       => 'is NOT equal (case insensitive) to',
        'lt'        => 'is less than',
        'gt'        => 'is greater than',
        'ge'        => 'is greater than or equal to',
        'le'        => 'is less than or equal to',
        'inc'       => 'includes (case sensitive)',
        'inci'      => 'includes (case insensitive)',
        'ninc'      => 'NOT includes (case sensitive)',
        'ninci'     => 'NOT includes (case insensitive)',
        're'        => 'matches regular expression',
        'begins'    => 'begins with (case sensitive)',
        'beginsi'   => 'begins with (case insensitive)',
        'in'        => 'is one of (case sensitive)',
        'ini'       => 'is one of (case insensitive)',
        'nin'       => 'is NOT one of (case sensitive)',
        'nini'      => 'is NOT one of (case insensitive)',
    );

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
    private $logic = self::CRITERION_LOGIC_UNION;

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
    private $key;

    /**
     * String representation of logic operands.
     *
     * @var     string
     */
    private $operand;

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
    private $type;

    /**
     * Either value or the name of the filed to compare.
     */
    private $value;

    /**
     * Gets Logic.
     *
     * @return string
     */
    public function getLogic()
    {
        return $this->logic;
    }

    /**
     * Alias of getLogic().
     *
     * @return string
     */
    public function logic()
    {
        return $this->getLogic();
    }

    /**
     * Sets Logic.
     *
     * @param   string  $logic
     * @return  Ucc\Filter\Criterion
     * @throws  InvalidArgumentException
     */
    public function setLogic($logic)
    {
        if  (!($logic == self::CRITERION_LOGIC_INTERSCTION || $logic == self::CRITERION_LOGIC_UNION)) {
            throw new InvalidArgumentException(
                "Expected Criterion->logic to be one of: "
                . self::CRITERION_LOGIC_INTERSCTION . " or "
                . self::CRITERION_LOGIC_UNION . ". Got " . $logic . " instead."
            );
        }

        $this->logic = $logic;

        return $this;
    }

    /**
     * Gets key.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Alias of getKey().
     */
    public function key()
    {
        return $this->getKey();
    }

    /**
     * Sets key.
     *
     * @param   string  $key
     * @return  Ucc\Filter\Criterion
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Gets operand.
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * Alias of getOperand().
     */
    public function op()
    {
        return $this->getOperand();
    }

    /**
     * Sets operand.
     */
    public function setOperand($operand)
    {
        if  (!(
            $operand == self::CRITERION_OP_BOOL
            || $operand == self::CRITERION_OP_EQ
            || $operand == self::CRITERION_OP_EQI
            || $operand == self::CRITERION_OP_NE
            || $operand == self::CRITERION_OP_NEI
            || $operand == self::CRITERION_OP_LT
            || $operand == self::CRITERION_OP_GT
            || $operand == self::CRITERION_OP_GE
            || $operand == self::CRITERION_OP_LE
            || $operand == self::CRITERION_OP_INC
            || $operand == self::CRITERION_OP_INCI
            || $operand == self::CRITERION_OP_NINC
            || $operand == self::CRITERION_OP_NINCI
            || $operand == self::CRITERION_OP_RE
            || $operand == self::CRITERION_OP_BEGINS
            || $operand == self::CRITERION_OP_BEGINSI
            || $operand == self::CRITERION_OP_IN
            || $operand == self::CRITERION_OP_INI
            || $operand == self::CRITERION_OP_NIN
            || $operand == self::CRITERION_OP_NINI
            )) {
            throw new InvalidArgumentException(
                "Expected Criterion->operand to be one of: "
                    . self::CRITERION_OP_BOOL
                    . ", " . self::CRITERION_OP_EQ
                    . ", " . self::CRITERION_OP_EQI
                    . ", " . self::CRITERION_OP_NE
                    . ", " . self::CRITERION_OP_NEI
                    . ", " . self::CRITERION_OP_LT
                    . ", " . self::CRITERION_OP_GT
                    . ", " . self::CRITERION_OP_GE
                    . ", " . self::CRITERION_OP_LE
                    . ", " . self::CRITERION_OP_INC
                    . ", " . self::CRITERION_OP_INCI
                    . ", " . self::CRITERION_OP_NINC
                    . ", " . self::CRITERION_OP_NINCI
                    . ", " . self::CRITERION_OP_RE
                    . ", " . self::CRITERION_OP_BEGINS
                    . ", " . self::CRITERION_OP_BEGINSI
                    . ", " . self::CRITERION_OP_IN
                    . ", " . self::CRITERION_OP_INI
                    . ", " . self::CRITERION_OP_NIN
                    . ", " . self::CRITERION_OP_NINI
                    . ". Got '" . $operand . "' instead."
            );
        }

        $this->operand = $operand;

        return $this;
    }

    /**
     * Gets type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Alias of getType().
     */
    public function type()
    {
        return $this->getType();
    }

    /**
     * Sets type.
     *
     * @param   string  $type
     * @return  Ucc\Filter\Criterion
     * @throws  InvalidArgumentException
     */
    public function setType($type)
    {
        if  (!($type == self::CRITERION_TYPE_FIELD || $type == self::CRITERION_TYPE_VALUE)) {
            throw new InvalidArgumentException(
                "Expected Criterion->type to be one of: "
                . self::CRITERION_TYPE_FIELD . " or "
                . self::CRITERION_TYPE_VALUE . ". Got '" . $type . "' instead."
            );
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Gets value.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Alias of getValue().
     */
    public function value()
    {
        return $this->getValue();
    }

    /**
     * Sets value.
     *
     * @param   string  $value
     * @return  Ucc\Filter\Criterion
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
