<?php

namespace Ucc\Data\Validator;

/**
 * Ucc\Data\Validator\Validator
 * Provides methods to validate data against defined checks
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Validator
{
    private $checks;

    public function __construct()
    {
        $this->checks = array();
    }

    public function getChecks()
    {
        return $this->checks();
    }

    public function setChecks()
    {
        foreach ($checks as $key => $check) {
            $this->setCheck($key, $check);
        }
    }

    /**
     * Checks inputs conformity with field checks set.
     */
    public function validate()
    {

    }
}
