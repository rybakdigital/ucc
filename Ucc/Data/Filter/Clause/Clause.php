<?php

namespace Ucc\Data\Filter\Clause;

use \InvalidArgumentException;
use Ucc\Data\Filter\Clause\ClauseInterface;

/**
 * Ucc\Data\Filter\Clause\Clause
 * Storage for filter clause.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Clause implements ClauseInterface
{
    /**
     * @var string
     */
    private $statement;

    /**
     * @var array
     */
    private $parameters;

    public function __construct()
    {
        $this->parameters = array();
    }

    /**
     * Gets Statement.
     *
     * @return string
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Alias of getStatement().
     *
     * @return string
     */
    public function statement()
    {
        return $this->getStatement();
    }

    /**
     * Sets Statement.
     *
     * @param   string  $statement
     * @return  ClauseInterface
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;

        return $this;
    }

    /**
     * Gets Parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Sets Parameters.
     *
     * @param   array  $parameters
     * @return  ClauseInterface
     */
    public function setParameters($parameters = array())
    {
        foreach ($parameters as $parameter => $value) {
            $this->setParameter($parameter, $value);
        }

        return $this;
    }

    /**
     * Sets Parameter.
     *
     * @param   string  $name
     * @param   mixed   $value
     * @return  ClauseInterface
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Gets Parameter.
     *
     * @return mixed    Returns parameter if exist, otherwise NULL
     */
    public function getParameter($parameter)
    {
        if (isset($this->parameters[$parameter])) {
            return $this->parameters[$parameter];
        }

        return null;
    }

    /**
     * Alias of getParameter().
     *
     * @return mixed
     */
    public function param($parameter)
    {
        return $this->getParameter($parameter);
    }

    /**
     * Removes logic from SQL statement.
     * Example:
     * 'AND `name` IS NOT NULL' will remove "AND " from the statement: '`name` IS NOT NULL'
     *
     * @return ClauseInterface
     */
    public function removeLogicFromStatement()
    {
        $statement = $this->getStatement();

        // The 'AND' or 'OR' should be somewhere at the very beginning of the statement
        $logicArea    = substr($statement, 0, 4);

        if (stripos($logicArea, 'and') !== false) {
            $this->setStatement(substr($statement, 4));
        } elseif (stripos($logicArea, 'or') !== false) {
            $this->setStatement(substr($statement, 3));
        }

        return $this;
    }
}
