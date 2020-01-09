<?php

namespace Ucc\Data\Filter;

use Ucc\Data\Filter\Criterion\Criterion;
use \InvalidArgumentException;

/**
 * Ucc\Data\Filter\Filter
 * Storage space that allows to group Criterion objects
 *
 * For example: In a given sets A, B, C, D
 * we would like to get an union of subsets (A and B) or (C and D).
 * We will create two Filter objects:
 * One that contains Criterion objects for intersection of A and B
 * the the second one with Criterion for intersection of C and D.
 * In addition we will have to describe logic operand that for each Filter.
 * AND is a default value and means that Filter must return result.
 * In our case this will be AND for first filter and OR for second Filter. In other
 * words our statement should look like: AND (A and B) OR (B and C). As the statement
 * is bing read from left to right the first "AND" will be omitted resulting in following:
 * (A and B)[Filter 1] OR (C and D)[Filter 2]
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Filter
{
    const FILTER_LOGIC_INTERSCTION   = 'and';    // Logic Intersection (AND A AND B AND C ...)
    const FILTER_LOGIC_UNION         = 'or';     // Logic Union (OR A OR B OR C ...)
    const FILTER_FIND_PROPERTY_KEY   = 'key';
    const FILTER_FIND_PROPERTY_VALUE = 'value';

    public static $filterLogic = array(
        self::FILTER_LOGIC_INTERSCTION,
        self::FILTER_LOGIC_UNION,
    );


    /**
     * @var array
     *
     * Array of Criterion objects
     */
    private $criterions;

    /**
     * @var string
     *
     * Logic quantifier
     */
    private $logic;

    public function __construct()
    {
        $this->criterions   = array();
        $this->logic        = self::FILTER_LOGIC_INTERSCTION;
    }

    /**
     * Get criterions
     *
     * @return array
     */
    public function getCriterions()
    {
        return $this->criterions;
    }

    /**
     * Set criterions
     *
     * @param   array       $criterions
     * @return  Filter
     */
    public function setCriterions(array $criterions)
    {
        foreach ($criterions as $criterion) {
            $this->addCriterion($criterion);
        }

        return $this;
    }

    /**
     * Add criterion
     *
     * @param   Criterion   $criterion
     * @return  Filter
     */
    public function addCriterion(Criterion $criterion)
    {
        $this->criterions[] = $criterion;

        return $this;
    }

    /**
     * Removes existing criterion from the filter
     *
     * @param   Criterion   $criterion
     * @return  Filter
     */
    public function removeCriterion(Criterion $criterion)
    {
        $key = array_search($criterion, $this->criterions);

        if ($key !== false) {
            unset($this->criterions[$key]);
        }

        return $this;
    }

    /**
     * Get logic
     *
     * @return string
     */
    public function getLogic()
    {
        return $this->logic;
    }

    /**
     * Alias of getLogic()
     *
     * @return string
     */
    public function logic()
    {
        return $this->getLogic();
    }

    /**
     * Set logic
     *
     * @param   string      $logic
     * @return  Filter
     */
    public function setLogic($logic)
    {
        // Convert logic to lower case (for consistency)
        $logic = strtolower($logic);

        if (!in_array($logic, self::$filterLogic)) {
            throw new InvalidArgumentException(
                "Expected Filter->logic to be one of: "
                . self::FILTER_LOGIC_INTERSCTION . " or "
                . self::FILTER_LOGIC_UNION . ". Got '" . $logic . "' instead."
                );
        }

        $this->logic = $logic;

        return $this;
    }

    /**
     * Finds first Criterion matching search conditions and returns it
     *
     * @param   mixed     $haystack     Needle or Haystack to search for, string, number, array
     * @param   string    $property     Property of Criterion to scan
     * @param   bool      $findAll      Whether to return first result or all
     * @return  mixed                   First matched element if found, otherwise null
     */
    public function findCriterion($haystack, $property = self::FILTER_FIND_PROPERTY_KEY, $findAll = false)
    {
        $keys = array();

        foreach ($this->criterions as $key => $criterion) {
            $method = 'get' . ucfirst($property);

            if (!method_exists($criterion, $method)) {
                throw new InvalidArgumentException(
                    "Argument 2 passed to Filter->findCriterion() must be one of: "
                    . self::FILTER_FIND_PROPERTY_KEY . " or "
                    . self::FILTER_FIND_PROPERTY_VALUE . ". Got '" . $property . "' instead."
                    );
            }

            $needle = $criterion->$method();

            if (is_array($haystack)) {
                if (in_array($needle, $haystack)) {
                    $keys[$key] = $criterion;
                }
            } elseif (is_numeric($haystack) || is_string($haystack)) {
                if ($needle == $haystack) {
                    $keys[$key] = $criterion;
                }
            } elseif (is_bool($haystack)) {
                if (in_array($needle, [true, false, 0, 1, 'true', 'false'], true)) {
                    $keys[$key] = $criterion;
                }
            } else {
                if ($needle === $haystack) {
                    $keys[$key] = $criterion;
                }
            }
        }

        if (!empty($keys)) {
            if ($findAll) {
                return $keys;
            }

            return reset($keys);
        }

        return null;
    }

    /**
     * Finds all Criterions matching search conditions and returns them as a list
     *
     * @param   mixed     $haystack     Needle or Haystack to search for, string, number, array
     * @param   string    $property     Property of Criterion to scan
     * @return  mixed                   Matched elements if found, otherwise []
     */
    public function findCriterions($haystack, $property = self::FILTER_FIND_PROPERTY_KEY)
    {
        $keys = $this->findCriterion($haystack, $property, true);

        if (!is_null($keys)) {
            return $keys;
        }

        return [];
    }
}
