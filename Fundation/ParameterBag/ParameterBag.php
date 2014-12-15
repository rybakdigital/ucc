<?php

namespace Ucc\Fundation\ParameterBag;

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
     */
    public function clear()
    {
        $this->parameters = array();
    }

    /**
     * Adds parameters to the parameters list.
     *
     * @param   array   $parameters     An array of parameters
     */
    public function add(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * Sets a parameter.
     *
     * @param string    $name           The parameter name
     * @param mixed     $value          The parameter value
     *
     * @api
     */
    public function set($name, $value)
    {
        $this->parameters[strtolower($name)] = $value;
    }

    /**
     * Gets a parameter.
     *
     * @param string $name The parameter name
     * @return mixed The parameter value
     * @throws ParameterNotFoundException if the parameter is not defined
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
}
