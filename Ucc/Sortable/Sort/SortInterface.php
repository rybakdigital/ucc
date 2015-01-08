<?php

namespace Ucc\Sortable\Sort;

/**
 * Ucc\Sortable\Sort\SortInterface.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
interface SortInterface
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
     * @return  Ucc\Sortable\Sort\Sort
     * @throws  InvalidArgumentException
     */
    public function setField($field);

    /**
     * Gets direction.
     *
     * @return string
     */
    public function getDirection();

    /**
     * Alias of getDirection().
     *
     * @return string
     */
    public function direction();

    /**
     * Sets direction.
     *
     * @param   string  $direction
     * @return  Ucc\Sortable\Sort\Sort
     * @throws  InvalidArgumentException
     */
    public function setDirection($direction);
}
