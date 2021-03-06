<?php

namespace Ucc\File\Path;

use \InvalidArgumentException;

/**
 * Ucc\File\Path\Path
 * This class provides methods to interact with file path
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Path
{
    /**
     * Gets extension form file path
     *
     * @param   string      $path
     * @return  string|null File extension if found, otherwise null
     */
    public static function getExtension($path)
    {
        if (!is_string($path)) {
            throw new InvalidArgumentException("Path needs to be a string");
        }

        // Match extension
        $re = "%\\.([a-zA-Z0-9]*)$%i";
        preg_match($re, $path, $matches);

        if (!empty($matches) && isset($matches[1])) {
            return $matches[1];
        }

        return null;
    }
}
