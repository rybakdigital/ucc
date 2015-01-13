<?php

namespace Ucc\Data\Format\Format;

/**
 * Ucc\Data\Format\Format\FormatInterface
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
interface FormatInterface
{
    /**
     * Gets format.
     *
     * @return string
     */
    public function getFormat();

    /**
     * Alias of getFormat().
     *
     * @return string
     */
    public function format();

    /**
     * Sets format.
     *
     * @param   string  $format
     * @return  Ucc\Data\Format\Format\Format
     * @throws  InvalidArgumentException
     */
    public function setFormat($format);
}
