<?php namespace Farzai\Guesser\Types;

class NullType extends AbstractType
{
    /**
     * @param $value
     * @return mixed
     */
    public function cast($value)
    {
        if (is_null($value)) {
            return $this->uses(null);
        }

        return $this->next($value);
    }
}