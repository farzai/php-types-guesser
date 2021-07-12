<?php namespace Farzai\Guesser\Types;

use Farzai\Guesser\Expression;

abstract class AbstractType implements Type
{
    /**
     * @param $value
     * @return Expression\Next
     */
    protected function next($value)
    {
        return new Expression\Next($value);
    }

    /**
     * @param $value
     * @return Expression\UseValue
     */
    protected function uses($value)
    {
        return new Expression\UseValue($value);
    }
}