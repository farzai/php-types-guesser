<?php namespace Farzai\Guesser\Types;

interface Type
{
    /**
     * @param $value
     * @param callable $next
     * @return mixed|\Farzai\Guesser\Expression\Expression
     */
    public function cast($value);
}