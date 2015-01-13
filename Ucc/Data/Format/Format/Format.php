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
}
