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
     * Set criterions
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
}
