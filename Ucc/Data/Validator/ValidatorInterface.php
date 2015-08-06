<?php

namespace Ucc\Data\Validator;

/**
 * Ucc\Data\Validator\ValidatorInterface
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
interface ValidatorInterface
{
    /**
     * Gets checks
     * Return list of checks for Validation
     *
     * @return array
     */
    public function getChecks();

    /**
     * Sets checks
     *
     * @param   array   $checks     Array of checks to perform
     * @return  Validator
     */
    public function setChecks(array $checks);

    /**
     * Clears all validation checks.
     *
     * @return  Validator
     */
    public function clearChecks();

    /**
     * Gets inputData
     *
     * @return  array
     */
    public function getInputData();

    /**
     * Clears the input data
     *
     * @return Validator
     */
    public function clearInputData();

    /**
     * Gets error
     *
     * @return  mixed           String if error occurred, otherwise false
     */
    public function getError();

    /**
     * Set InputData
     *
     * @param   array       $data
     * @return  Validator
     */
    public function setInputData(array $data);

    /**
     * Gets safeData
     *
     * @return  array
     */
    public function getSafeData();

    /**
     * Clears safe data
     *
     * @return Validator
     */
    public function clearSafeData();

    /**
     * Validates data.
     * Return TRUE if data is valid, othervise false
     *
     * @return boolean
     */
    public function validate();
}
