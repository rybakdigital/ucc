<?php

namespace Ucc\Db\Filter;

use Ucc\Data\Filter\Criterion\Criterion;

/**
 * Ucc\Db\Filter\Dql
 * DQL does not yet support case-sensitive searches
 *
 * @author Kris Rybak <kris@krisrybak.com>
 */
class Dql
{
    public static function getExprValue($value, $qb)
    {
        if ($value instanceof \DateTime) {
            return $qb->expr()->literal($value->format('Y-m-d H:i:s'));
        }

        if (is_string($value)) {
            return $qb->expr()->literal($value);
        }

        return $value;
    }

    /**
     * Transforms direct methods to DQL
     *
     * @param   Criterion
     * @param   QueryBuilder
     * @return  Doctrine\ORM\Query\Expr\Func
     */
    public static function criterionToDirectClause(Criterion $criterion, $qb)
    {
        switch($criterion->op())
        {
            case 'eq':
            case 'eqi':
                $expr = $qb->expr()->eq($criterion->key(), self::getExprValue($criterion->value(), $qb));
                break;
            case 'ne':
            case 'nei':
                $expr = $qb->expr()->neq($criterion->key(), self::getExprValue($criterion->value(), $qb));
                break;
        }

        return $expr;
    }

    /**
     * Transforms bool method to DQL
     *
     * @param   Criterion
     * @param   QueryBuilder
     * @return  Doctrine\ORM\Query\Expr\Func
     */
    public static function criterionToBoolClause(Criterion $criterion, $qb)
    {
        switch($criterion->op())
        {
            case 'bool':

                if ($criterion->value() == 'true' || $criterion->value() == 1) {
                    $expr = $qb->expr()->orX(
                        $qb->expr()->eq($criterion->key(), $criterion->value()),
                        $expr = $qb->expr()->andX(
                            $qb->expr()->isNotNull($criterion->key()),
                            $qb->expr()->neq($criterion->key(), 0) // not NULL and not 0
                        )
                    );
                } elseif ($criterion->value() == 'false' || $criterion->value() == 0) {
                    $expr = $qb->expr()->orX(
                        $qb->expr()->eq($criterion->key(), $criterion->value()),
                        $qb->expr()->isNull($criterion->key())
                    );
                }

                break;
        }

        return $expr;
    }

    /**
     * Transforms relative methods to DQL
     *
     * @param   Criterion
     * @param   QueryBuilder
     * @return  Doctrine\ORM\Query\Expr\Func
     */
    public static function criterionToRelativeClause(Criterion $criterion, $qb)
    {
        switch($criterion->op())
        {
            case 'gt':
                $expr = $qb->expr()->gt($criterion->key(), self::getExprValue($criterion->value(), $qb));
                break;
            case 'ge':
                $expr = $qb->expr()->gte($criterion->key(), self::getExprValue($criterion->value(), $qb));
                break;
            case 'lt':
                $expr = $qb->expr()->lt($criterion->key(), self::getExprValue($criterion->value(), $qb));
                break;
            case 'le':
                $expr = $qb->expr()->lte($criterion->key(), self::getExprValue($criterion->value(), $qb));
                break;
        }

        return $expr;
    }

    /**
     * Transforms contains methods to DQL
     *
     * @param   Criterion
     * @param   QueryBuilder
     * @return  Doctrine\ORM\Query\Expr\Func
     */
    public static function criterionToContainsClause(Criterion $criterion, $qb)
    {
        switch($criterion->op())
        {
            case 'inc':
            case 'inci':
                $expr = $qb->expr()->like($criterion->key(), $qb->expr()->literal('%' . $criterion->value() . '%'));
                break;
            case 'ninc':
            case 'ninci':
                $expr = $qb->expr()->notLike($criterion->key(), $qb->expr()->literal('%' . $criterion->value() . '%'));
                break;
        }

        return $expr;
    }

    /**
     * Transforms begins with to DQL
     *
     * @param   Criterion
     * @param   QueryBuilder
     * @return  Doctrine\ORM\Query\Expr\Func
     */
    public static function criterionToBeginsClause(Criterion $criterion, $qb)
    {
        switch($criterion->op())
        {
            case 'begins':
            case 'beginsi':
                $expr = $qb->expr()->like($criterion->key(), $qb->expr()->literal($criterion->value() . '%'));
                break;
            case 'nbegins':
            case 'nbeginsi':
                $expr = $qb->expr()->notLike($criterion->key(), $qb->expr()->literal($criterion->value() . '%'));
                break;
        }

        return $expr;
    }

    /**
     * Transforms list of values to match to DQL
     *
     * @param   Criterion
     * @param   QueryBuilder
     * @return  Doctrine\ORM\Query\Expr\Func
     */
    public static function criterionToInClause(Criterion $criterion, $qb)
    {
        $inArray = explode(',', $criterion->value());

        switch($criterion->op())
        {
            case 'in':
            case 'ini':
                $expr = $qb->expr()->in($criterion->key(), $inArray);
                break;
            case 'nin':
            case 'nini':
                $expr = $qb->expr()->notIn($criterion->key(), $inArray);
                break;
        }

        return $expr;
    }
}
