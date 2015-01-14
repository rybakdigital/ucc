<?php

namespace Ucc\Data\Format\Display;

/**
 * Ucc\Data\Format\Display\DisplayInterface
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
interface DisplayInterface
{
    /**
     * Gets field.
     *
     * @return string
     */
    public function getField();

    /**
     * Alias of getField().
     *
     * @return string
     */
    public function field();

    /**
     * Sets field.
     *
     * @param   string  $field
     * @return  Ucc\Data\Format\Display\Display
     */
    public function setField($field);

    /**
     * Gets alias.
     *
     * @return string
     */
    public function getAlias();

    /**
     * Alias of getAlias().
     *
     * @return string
     */
    public function alias();

    /**
     * Sets alias.
     *
     * @param   string  $alias
     * @return  Ucc\Data\Format\Display\Display
     */
    public function setAlias($alias);

    /**
     * Turns Display into string in the following format: {field}-{alias}
     *
     * @return  string
     */
    public function toString();
}
