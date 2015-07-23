<?php

namespace Ucc\Data\Validator;

use Ucc\Data\Validator\Check\Check;

/**
 * Ucc\Data\Validator\Validator
 * Provides methods to validate data against defined checks
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Validator
{
    /**
     * @var     array   Array of checks to perform
     */
    private $checks;

    /**
     * @var     mixed   Error message if validation fails, otherwise false
     */
    private $error;

    /**
     * @var     array   Data to be validated
     */
    private $inputData;

    /**
     * @var     array   Safe data (passing checks)
     */
    private $safeData;

    public function __construct()
    {
        $this->checks       = array();
        $this->inputData    = array();
        $this->safeData     = array();
        $this->error        = false;
    }

    /**
     * Gets list of checks
     *
     * @return  array
     */
    public function getChecks()
    {
        return $this->checks;
    }

    /**
     * Sets checks
     *
     * @param   array   $checks     Array of checks to perform
     * @return  Validator
     */
    public function setChecks(array $checks)
    {

        foreach ($checks as $key => $check) {
            if (is_a($check, 'Ucc\Data\Validator\Check\Check')) {
                $this->addCheck($check);
            } elseif (is_array($check)) {
                $checkObj = new Check();
                $checkObj->fromArray(array($key => $check));
                $this->addCheck($checkObj);
            }
        }

        return $this;
    }

    /**
     * Sets checks
     *
     * @param   string  $key        Input key to apply check to
     * @param   array   $check      Validation criteria
     * @return  Validator
     */
    public function addCheck(Check $check)
    {
        $this->checks[$check->getKey()] = $check;

        return $this;
    }

    /**
     * Clears all validation checks.
     *
     * @return  Validator
     */
    public function clearChecks()
    {
        $this->checks = array();

        return $this;
    }

    /**
     * Gets error
     *
     * @return  mixed           String if error occurred, otherwise false
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set error
     *
     * @param   mixed       $message
     * @return  Validator
     */
    public function setError($message)
    {
        $this->error = $message;

        return $this;
    }

    /**
     * Gets inputData
     *
     * @return  array
     */
    public function getInputData()
    {
        return $this->inputData;
    }

    /**
     * Gets input
     *
     * @param   string  $key
     * @return  mixed
     */
    public function getInput($key)
    {
        $inputData = $this->getInputData();

        if (isset($inputData[$key])) {
            return $inputData[$key];
        }

        return null;
    }

    /**
     * Set InputData
     *
     * @param   array       $data
     * @return  Validator
     */
    public function setInputData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->addInputData($key, $value);
        }

        return $this;
    }

    /**
     * Add InputData
     *
     * @param   string      $key
     * @param   mixed       $value
     * @return  Validator
     */
    public function addInputData($key, $value)
    {
        $this->inputData[$key] = $value;

        return $this;
    }

    /**
     * Gets safeData
     *
     * @return  array
     */
    public function getSafeData()
    {
        return $this->safeData;
    }

    /**
     * Set safeData
     * safeData can only be set internally
     *
     * @return  Validator
     */
    private function setSafeData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->addSafeData($key, $value);
        }

        return $this;
    }

    /**
     * Adds safeData
     * Can only be called internally to prevent data overwrite
     *
     * @param   string  $key
     * @param   mixed   $value
     * @return  Validator
     */
    private function addSafeData($key, $value)
    {
        $this->safeData[$key] = $value;

        return $this;
    }

    /**
     * Clears the input data
     *
     * @return Validator
     */
    public function clearInputData()
    {
        $this->inputData = array();
    }

    /**
     * Checks inputs conformity with field checks set.
     */
    public function validate()
    {
        // Loop through the checks and evaluate each field
        foreach ($this->checks as $key => $check) {
            // Check the key exist in inputData
            if (isset($this->inputData[$key])) {
                if ($check->hasRequirement('type')) {
                    $this->checkInput($this->getInput($key), $check);
                }
            } else {
                // Check if field is optional
                if (!$check->hasRequirement('opt') || $check->getRequirement('opt') == false) {
                    $this->setError('Required parameter "' . $key . '" missing');
                    break;
                } else {
                    // Set default value if provided
                    if ($check->hasRequirement('default')) {
                        $this->addSafeData($key, $check->getRequirement('default'));
                    }

                    continue;
                }
            }
        }
    }

    /**
     * Validates input field
     */
    private function checkInput($input, $check)
    {

    }
}
