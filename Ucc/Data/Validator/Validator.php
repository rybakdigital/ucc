<?php

namespace Ucc\Data\Validator;

use Ucc\Data\Validator\Check\Check;
use Ucc\Data\Types\Basic\BasicTypes;
use Ucc\Data\Types\Pseudo\PseudoTypes;
use Ucc\Exception\Data\InvalidDataException;
use Ucc\Data\Validator\ValidatorInterface;

/**
 * Ucc\Data\Validator\Validator
 * Provides methods to validate data against defined checks
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Validator implements ValidatorInterface
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
     * Resets validator
     */
    public function reset()
    {
        $this
            ->clearChecks()
            ->clearInputData()
            ->clearSafeData()
            ->clearError();

        return $this;
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
     * Clears error.
     *
     * @return  Validator
     */
    public function clearError()
    {
        $this->error = null;

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

        return $this;
    }

    /**
     * Clears safe data
     *
     * @return Validator
     */
    public function clearSafeData()
    {
        $this->safeData = array();

        return $this;
    }

    /**
     * Checks inputs conformity with field checks set.
     *
     * @return boolean
     */
    public function validate()
    {
        // Loop through the checks and evaluate each field
        foreach ($this->checks as $key => $check) {
            // Check the key exist in inputData
            if (array_key_exists($key, $this->inputData)) {
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

        return ($this->getError()) ? false : true;
    }

    /**
     * Validates input field
     *
     * @param mixed $input      Data to validate
     * @param Check $check      Check to perform on input data
     * @return Validator
     */
    private function checkInput($input, $check)
    {
        $ret = false;

        // Check is specific type required
        if ($check->hasRequirement('type')) {
            $type = $check->getRequirement('type');

            if (in_array($type, array_keys(BasicTypes::$knownTypes))) {
                $method     = BasicTypes::$knownTypes[$type];
                $callable   = array('Ucc\Data\Types\Basic\BasicTypes', $method);
            } elseif (in_array($type, array_keys(PseudoTypes::$knownTypes))) {
                $method     = PseudoTypes::$knownTypes[$type];
                $callable   = array('Ucc\Data\Types\Pseudo\PseudoTypes', $method);
            // Check if custom class is called
            } elseif ($type == 'custom' && $check->hasRequirement('class') && $check->hasRequirement('method')) {
                $method     = $check->getRequirement('method');
                $callable   = array($check->getRequirement('class'), $method);
            }
        }

        $res = $this->checkValue($check->getKey(), $input, $check->getRequirements(), $callable);

        return $this;
    }

    /**
     * Validates value of the field against requirements
     *
     * @param   string  $key            Field name to check
     * @param   mixed   $value          Value to check
     * @param   array   $requirements   Array of requirements
     * @param   array   $callable       Array of class name and method to call
     * @return  mixed                   Validator if successful, otherwise false
     */
    private function checkValue($key, $value, $requirements, $callable)
    {
        if (is_callable($callable)) {
            $args = array($value, $requirements);
            try {
                // Call method to validate data
                if (isset($requirements['empty']) && ($requirements['empty'] === true) && (empty($value) && $value != 0)) {
                    $result = null;
                } else {
                    $result = call_user_func_array($callable, $args);
                }

                if (isset($requirements['as'])) {
                    $this->addSafeData($requirements['as'], $result);
                } else {
                    $this->addSafeData($key, $result);
                }
                return $this;
            } catch (\Exception $e) {
                $this->setError('Field ' . $key . ' failed validation because ' . $e->getMessage());
            }
        } else {
            $this->setError('Unkown check type for field ' . $key);
        }

        return false;
    }
}
