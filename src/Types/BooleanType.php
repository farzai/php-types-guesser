<?php namespace Farzai\Guesser\Types;

class BooleanType extends AbstractType
{

    public function cast($value)
    {
        if (is_string($value)) {
            // Boolean
            if (strtolower($value) === "true") {
                return $this->uses(true);
            } else if (strtolower($value) === "false") {
                return $this->uses(false);
            }
        }

        if (is_bool($value)) {
            return $this->uses($value);
        }

        return $this->next($value);
    }
}