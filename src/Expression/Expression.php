<?php namespace Farzai\Guesser\Expression;

abstract class Expression
{

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Next constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function resolve()
    {
        return $this->value;
    }
}