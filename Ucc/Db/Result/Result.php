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

    public static $validStatementTypes = array(
        'PDOStatement',
    );

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
        if (!in_array(get_class($statement), self::$validStatementTypes)) {
            throw new \InvalidArgumentException("Invalid Result statement type: '" . get_class($statement) . "' Supported types are: " . implode(', ', self::$validStatementTypes));
        }

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
    public function __construct($statement, $returnType = \PDO::FETCH_OBJ)
    {
        $this->setStatement($statement);
        $this->setReturnType($returnType);
    }

    /**
     * Returns all results
     */
    public function getAll()
    {
        if (is_a($this->getStatement(), '\PDOStatement')) {
            return $this->getStatement()->fetchAll($this->getReturnType());
        }

        return false;
    }

    /**
     * Returns current result
     */
    public function getNext()
    {
        if (is_a($this->getStatement(), '\PDOStatement')) {
            return $this->getStatement()->fetch($this->getReturnType());
        }

        return false;
    }

    /**
     * Returns the number of rows affected
     */
    public function getRowCount()
    {
        if (is_a($this->getStatement(), '\PDOStatement')) {
            return $this->getStatement()->rowCount();
        }

        return false;
    }
}
