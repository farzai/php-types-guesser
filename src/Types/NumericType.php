<?php namespace Farzai\Guesser\Types;

class NumericType extends AbstractType
{

    /**
     * @param $value
     * @return float|int|mixed
     */
    public function cast($value)
    {
        // Numeric
        if (is_numeric($value)) {
            if (strrpos((string)$value, '.') === false) {
                return $this->uses((int)$value);
            }

            return $this->uses((float)$value);
        }

        return $this->next($value);
    }
}