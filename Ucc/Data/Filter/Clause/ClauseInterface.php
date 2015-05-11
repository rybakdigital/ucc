<?php

namespace Ucc\Data\Filter\Clause;

/**
 * Ucc\Data\Filter\Clause\ClauseInterface
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
interface ClauseInterface
{
    /**
     * Gets Statement.
     *
     * @return string
     */
    public function getStatement();

    /**
     * Alias of getStatement().
     *
     * @return string
     */
    public function statement();

    /**
     * Sets Statement.
     *
     * @param   string  $statement
     * @return  ClauseInterface
     */
    public function setStatement($statement);

    /**
     * Gets Parameters.
     *
     * @return array
     */
    public function getParameters();

    /**
     * Sets Parameters.
     *
     * @param   array  $parameters
     * @return  ClauseInterface
     */
    public function setParameters($parameters = array());

    /**
     * Sets Parameter.
     *
     * @param   string  $name
     * @param   mixed   $value
     * @return  ClauseInterface
     */
    public function setParameter($name, $value);

    /**
     * Gets Parameter.
     *
     * @return mixed    Returns parameter if exist, otherwise NULL
     */
    public function getParameter($parameter);

    /**
     * Alias of getParameter().
     *
     * @return mixed
     */
    public function param($parameter);
}
