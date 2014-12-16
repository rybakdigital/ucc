<?php

namespace Ucc\Config\ParameterBag;

/**
 * Ucc\Config\ParameterBag\ParameterBagInterface.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
interface ParameterBagInterface
{
    /**
     * Clears all parameters.
     */
    public function clear();

    /**
     * Adds parameters to the parameters list.
     * Existing parameters will be preserved.
     *
     * @param   array   $parameters     An array of parameters
     * @return  Ucc\Config\ParameterBag\ParameterBagInterface
     */
    public function add(array $parameters);

    /**
     * Sets a parameter.
     *
     * @param   string    $name           The parameter name
     * @param   mixed     $value          The parameter value
     * @return  Ucc\Config\ParameterBag\ParameterBagInterface
     */
    public function set($name, $value);

    /**
     * Gets a parameter.
     *
     * @param   string $name The parameter name
     * @return  mixed The parameter value
     * @throws  ParameterNotFoundException if the parameter is not defined
     */
    public function get($name);

    /**
     * Gets all parameters.
     *
     * @return array    An array of parameters
     */
    public function all();

    /**
     * Gets all parameters.
     * Alias of all().
     *
     * @return array    An array of parameters
     */
    public function getAll();

    /**
     * Returns true if a parameter name is defined.
     *
     * @param   string      $name       The parameter name
     * @return  boolean     True if the parameter name is defined, otherwise false
     */
    public function has($name);
}
