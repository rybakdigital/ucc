<?php

namespace Ucc\Data\Validator\Check;

/**
 * Ucc\Data\Validator\Validator\Check\Check
 * Provides methods and storage for a single check.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Check
{
    /**
     * @var     string  Check identifier, i.e. key, field name
     */
    private $key;

    /**
     * @var     array   Array of requirements
     */
    private $requirements;

    public function __construct()
    {
        $this->requirements = array();
    }

    /**
     * Gets key
     *
     * @return  string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets key
     *
     * @param   string  $key
     * @return  Check
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Gets requirements
     *
     * @return  array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Sets requirements
     *
     * @param   array   $requirements
     * @return  Check
     */
    public function setRequirements(array $requirements)
    {
        foreach ($requirements as $rule => $condition) {
            $this->addRequirement($rule, $condition);
        }

        return $this;
    }

    /**
     * Adds single requirements
     *
     * @param   string  $rule           Type of criteria
     * @param   mixed   $condition      Requisites to be met
     * @return  Check
     */
    public function addRequirement($rule, $condition)
    {
        $this->requirements[$rule] = $condition;

        return $this;
    }

    /**
     * Allows to import check from array
     *
     * @param   array   $check          Array of key => requirements (array) that will be imported to check
     *                                  Example: array('name' => array('min' => 1, 'opt' => true))
     * @return  Check
     */
    public function fromArray(array $check)
    {
        foreach ($check as $key => $requirements) {
            $this->setKey($key);
            $this->setRequirements($requirements);
        }

        return $this;
    }
}
