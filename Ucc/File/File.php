<?php

namespace Ucc\File;

use \InvalidArgumentException;

/**
 * Ucc\File\File
 * This class provides methods to interact with files
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class File
{
    /**
     * Gets content of the file
     *
     * @param   string      $fileName
     * @return  string      Content of the file
     * @throws  InvalidArgumentException
     */
    public static function getContent($fileName = null)
    {
        // Check filename specified
        if (empty($fileName)) {
            throw new InvalidArgumentException("You must specify name of the file to get content for");
        }

        // Check file exists
        if (!file_exists($fileName)) {
            throw new InvalidArgumentException("File " . $fileName . " could not be found");
        }

        return file_get_contents($fileName);
    }

    /**
     * Alias of getContent()
     *
     * @param   string      $fileName
     * @return  string      Content of the file
     * @throws  InvalidArgumentException
     */
    public static function load($fileName = null)
    {
        self::getContent($fileName);
    }
}
