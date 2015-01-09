<?php

namespace Ucc\Data\Format\Display;

use \InvalidArgumentException;
use Ucc\Data\Format\Display\DisplayInterface;

/**
 * Ucc\Data\Format\Display\Display
 * Allows to represent display directive in sting logic format
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Display implements DisplayInterface
{
    /**
     * Represents field part of the display. Defines which field to display.
     * Example:
     * fields = array('id, 'name', 'location');
     * {field} : "id" tells filter to display only id from the group.
     *
     * @var     string
     */
    private $field;

    /**
     * Represents alias part of the display. Defines alias for field name.
     * Example:
     * {field}-{alias} : "product_id-id" tells filter to display "product_id" as "id"
     * {field}-{alias} : "city-town" tells filter to display "city" as "town"
     *
     * @var     string
     */
    private $alias;

    /**
     * Gets field.
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Alias of getField().
     *
     * @return string
     */
    public function field()
    {
        return $this->getField();
    }

    /**
     * Sets field.
     *
     * @param   string  $field
     * @return  Ucc\Data\Format\Display\Display
     * @throws  InvalidArgumentException
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Gets alias.
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Alias of getAlias().
     *
     * @return string
     */
    public function alias()
    {
        return $this->getAlias();
    }

    /**
     * Sets alias.
     *
     * @param   string  $alias
     * @return  Ucc\Data\Format\Display\Display
     * @throws  InvalidArgumentException
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Turns Display into string in the following format: {field}-{alias}
     *
     * @return  Ucc\Data\Format\Display\Display
     */
    public function toString()
    {
        if (empty($this->alias())) {
            return $this->field;
        }

        return $this->field() . '-' . $this->alias();
    }
}
