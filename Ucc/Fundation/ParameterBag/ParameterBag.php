<?php

namespace Ucc\Fundation\ParameterBag;

use Ucc\Exception\ParameterNotFoundException;

/**
 * This class provides utility methods for reading and storing parameters.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class ParameterBag
{
    /**
     * Array of parameters.
     * All keys will be converted to lowercase.
     *
     * @var array
     */
    protected $parameters = array();

    /**
     * Constructor.
     *
     * @param array     $parameters     An array of parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->add($parameters);
    }

    /**
     * Clears all parameters.
     *
     * @return  Ucc\Fundation\ParameterBag\ParameterBag
     */
    public function clear()
    {
        $this->parameters = array();

        return $this;
    }

    /**
     * Adds parameters to the parameters list.
     *
     * @param   array   $parameters     An array of parameters
     * @return  Ucc\Fundation\ParameterBag\ParameterBag
     */
    public function add(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * Sets a parameter.
     *
     * @param   string    $name           The parameter name
     * @param   mixed     $value          The parameter value
     * @return  Ucc\Fundation\ParameterBag\ParameterBag
     */
    public function set($name, $value)
    {
        $this->parameters[strtolower($name)] = $value;

        return $this;
    }

    /**
     * Gets a parameter.
     *
     * @param   string $name The parameter name
     * @return  mixed The parameter value
     * @throws  ParameterNotFoundException if the parameter is not defined
     */
    public function get($name)
    {
        $name = strtolower($name);

        // Check if name exists in parameters array
        if (!array_key_exists($name, $this->parameters)) {
            throw new ParameterNotFoundException($name);
        }

        return $this->parameters[$name];
    }

    /**
     * Gets all parameters.
     *
     * @return array    An array of parameters
     */
    public function getAll()
    {
        return $this->all();
    }

    /**
     * Gets all parameters.
     *
     * @return array    An array of parameters
     */
    public function all()
    {
        return $this->parameters;
    }

    /**
     * Returns true if a parameter name is defined.
     *
     * @param   string      $name       The parameter name
     * @return  boolean     True if the parameter name is defined, otherwise false
     */
    public function has($name)
    {
        return array_key_exists(strtolower($name), $this->parameters);
    }
}
