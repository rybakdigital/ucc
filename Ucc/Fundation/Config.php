<?php

namespace Ucc\Fundation;

use Ucc\Fundation\ParameterBag\ParameterBag;

/**
 * This class provides utility methods for reading and storing configuration.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Config
{
    /**
     * @var ParameterBagInterface;
     */
    private $parameterBag;

    public function __construct($parameterBag = null)
    {
        $this->parameterBag = $parameterBag ?: new ParameterBag();
    }

    /**
     * Gets the parameter bag.
     */
    public function getParameterBag()
    {
        return $this->parameterBag;
    }

    /**
     * Gets a parameter.
     *
     * @param string    $name   Name of the parameter
     */
    public function getParameter($name)
    {
        return $this->parameterBag->get($name);
    }

    /**
     * Checks if parameter exists.
     *
     * @param string    $name   Name of the parameter
     */
    public function hasParameter($name)
    {
        return $this->parameterBag->has($name);
    }

    /**
     * Sets a parameter.
     *
     * @param string $name  The parameter name
     * @param mixed  $value The parameter value
     */
    public function setParameter($name, $value)
    {
        $this->parameterBag->set($name, $value);
    }
}
