<?php

namespace Ucc\Data\Format\Format;

use Ucc\Data\Format\Format\FormatInterface;

/**
 * Ucc\Data\Format\Format\Format
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Format implements FormatInterface
{
    const FORMAT_JSON           = 'json';       // JSON array: [{"foo":1},{"bar":2}]
    const FORMAT_JSONSTREAM     = 'jsonstream'; // JSON encoded objects, separated by newlines:
                                                // {"foo":1}
                                                // {"bar":2}
    const FORMAT_DEBUG          = 'debug';      // human-readable format that JSON

    public static $formatOptions = array(
        self::FORMAT_JSON,
        self::FORMAT_JSONSTREAM,
        self::FORMAT_DEBUG,
    );

    /**
     * Represents format part of the Format. Defines which format to use whet outputing data.
     *
     * @var     string
     */
    private $format;

    /**
     * Gets format.
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Alias of getFormat().
     *
     * @return string
     */
    public function format()
    {
        return $this->getFormat();
    }

    /**
     * Sets format.
     *
     * @param   string  $format
     * @return  Ucc\Data\Format\Format\Format
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Turns Format into string in the following format: {format}
     *
     * @return string
     */
    public function toString()
    {
        return $this->format();
    }
}
