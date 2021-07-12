<?php namespace Farzai\Guesser\Types;

use Farzai\Guesser\TypeGuesser;

class JsonType extends AbstractType
{

    /**
     * @param $value
     * @return mixed|void
     */
    public function cast($value)
    {
        // String
        if (is_string($value)) {

            $json = @json_decode($value, true);
            if (is_array($json)) {
                $value = $json;
            }
        }

        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = TypeGuesser::toDynamicType($val);
            }

            return $this->uses($value);
        }

        return $this->next($value);
    }
}