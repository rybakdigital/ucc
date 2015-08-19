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
    public static function getExtentsion($path)
    {
        if (!is_string($path)) {
            throw new InvalidArgumentException("Path needs to be a string");
        }

        // Find position of extension separator
        $extensionSeparatorPos = strrpos($path, '.');

        // Start point for extension is extensionSeparatorPos + position of . (dot)
        if (!empty($extensionSeparatorPos)) {
            $start = $extensionSeparatorPos + 1;

            return substr($path, $start);
        }

        return null;
    }
}
