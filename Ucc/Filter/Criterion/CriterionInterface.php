<?php

namespace Ucc\Filter\Criterion;

/**
 * Ucc\Filter\Criterion\CriterionInterface.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
interface CriterionInterface
{
    /**
     * Gets Logic.
     *
     * @return string
     */
    public function getLogic();

    /**
     * Alias of getLogic().
     *
     * @return string
     */
    public function logic();

    /**
     * Sets Logic.
     *
     * @param   string  $logic
     * @return  Ucc\Filter\Criterion
     * @throws  InvalidArgumentException
     */
    public function setLogic($logic);

    /**
     * Gets key.
     */
    public function getKey();

    /**
     * Alias of getKey().
     */
    public function key();

    /**
     * Sets key.
     *
     * @param   string  $key
     * @return  Ucc\Filter\Criterion
     */
    public function setKey($key);

    /**
     * Gets operand.
     */
    public function getOperand();

    /**
     * Alias of getOperand().
     */
    public function op();

    /**
     * Sets operand.
     */
    public function setOperand($operand);

    /**
     * Gets type.
     */
    public function getType();

    /**
     * Alias of getType().
     */
    public function type();

    /**
     * Sets type.
     *
     * @param   string  $type
     * @return  Ucc\Filter\Criterion
     * @throws  InvalidArgumentException
     */
    public function setType($type);

    /**
     * Gets value.
     */
    public function getValue();

    /**
     * Alias of getValue().
     */
    public function value();

    /**
     * Sets value.
     *
     * @param   string  $value
     * @return  Ucc\Filter\Criterion
     */
    public function setValue($value);
}
