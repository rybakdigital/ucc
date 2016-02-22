<?php

namespace Ucc\Db\Result;

/**
* Ucc\Db\Result\Result
*/
class Result
{
    /**
     * Executed statement
     */
    private $statement;

    private $returnType;

    /**
     * Gets statement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Sets statement
     */
    public function setStatement($statement)
    {
        return $this->statement = $statement;
    }

    /**
     * Gets return type
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * Sets return type
     */
    public function setReturnType($returnType)
    {
        return $this->returnType = $returnType;
    }

    /**
     * @param $statement    Executed statment
     */
    public function __construct($statement)
    {
        $this->statement = $statement;
        $this->returnType = \PDO::FETCH_OBJ;
    }

    /**
     * Returns all results
     */
    public function getAll()
    {
        return $this->getStatement()->fetchAll($this->getReturnType());
    }

    /**
     * Returns current result
     */
    public function getNext()
    {
        return $this->getStatement()->fetch($this->getReturnType());
    }

    /**
     * Returns the number of rows affected
     */
    public function getRowCount()
    {
        return $this->getStatement()->rowCount();
    }
}
