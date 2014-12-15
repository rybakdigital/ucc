<?php

namespace Ucc\Exception;

use \Exception;

/**
 * This exception is thrown when a non-existent parameter is used.
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class ParameterNotFoundException extends Exception
{
    private $key;

    /**
     * Constructor.
     *
     * @param string     $key          The requested parameter key
     */
    public function __construct($key)
    {
        $this->key = $key;

        $this->message = sprintf('You have requested a non-existent parameter "%s".', $this->key);
    }
}
