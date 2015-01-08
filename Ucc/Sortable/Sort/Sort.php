<?php

namespace Ucc\Sortable\Sort;

use \InvalidArgumentException;
use Ucc\Sortable\Sort\SortInterface;

/**
 * Ucc\Sortable\Sort\Sort
 * Allows to represent sort directive in sting logic format
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Sort implements SortInterface
{
    const SORT_DIRECTION_ASC   = 'asc';     // Ascending order
    const SORT_DIRECTION_DESC  = 'desc';    // Descending order

    /**
     * Represents field part of the sort. Defines which field to apply sort to.
     * Example:
     * {field}-{direction} : "id-asc" Orders by field name "id" ascending i.e. (1-99)
     * {field}-{direction} : "name-desc" Orders by field name "name" descending i.e. (Z-A)
     *
     * @var     string
     */
    private $field;

    /**
     * Represents direction part of the sort. Defines which whether the order should be ASC or DESC.
     * DEFAULT direction is set ASC.
     * Example:
     * {field}-{direction} : "id-asc" Orders by field name "id" ascending i.e. (1-99)
     * {field}-{direction} : "name-desc" Orders by field name "name" descending i.e. (Z-A)
     *
     * @var     string
     */
    private $direction;

    public function __construct()
    {
        $this->direction = self::SORT_DIRECTION_ASC;
    }

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
     * @return  Ucc\Sortable\Sort\Sort
     * @throws  InvalidArgumentException
     */
    public function setField($field);
    {
        // Make sure we use lower case only
        $field = strtolower($field);

        $this->field = $field;

        return $this;
    }

    /**
     * Gets direction.
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Alias of getDirection().
     *
     * @return string
     */
    public function direction();
    {
        return $this->getDirection();
    }

    /**
     * Sets direction.
     *
     * @param   string  $direction
     * @return  Ucc\Sortable\Sort\Sort
     * @throws  InvalidArgumentException
     */
    public function setDirection($direction);
    {
        // Make sure we use lower case only
        $direction = strtolower($direction);

        if  (!($direction == self::SORT_DIRECTION_ASC || $direction == self::SORT_DIRECTION_DESC)) {
            throw new InvalidArgumentException(
                "Expected Sort->direction to be one of: "
                . self::SORT_DIRECTION_ASC . " or "
                . self::SORT_DIRECTION_DESC . ". Got " . $direction . " instead."
            );
        }

        $this->direction = $direction;

        return $this;
    }
}
