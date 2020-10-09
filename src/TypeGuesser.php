<?php namespace Farzai\Guesser;

use JsonSerializable;

class TypeGuesser implements JsonSerializable
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var mixed
     */
    private $originalValue;

    /**
     * @param $value
     * @return static
     */
    public static function of($value)
    {
        $instance = new static;
        $instance->originalValue = $value;
        $instance->value = static::toDynamicType($value);

        return $instance;
    }

    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getOriginalValue()
    {
        return $this->originalValue;
    }


    /**
     * @param $value
     * @return array|bool|float|int|mixed|string|null
     */
    public static function toDynamicType($value)
    {
        // Null
        if (is_null($value)) {
            return null;
        }

        // Numeric
        if (is_numeric($value)) {
            if (strrpos((string)$value, '.') === false) {
                return (int)$value;
            }

            return (float)$value;
        }

        // String
        if (is_string($value)) {
            // Boolean
            if (strtolower($value) === "true") {
                return true;
            } else if (strtolower($value) === "false") {
                return false;
            }

            // Json type
            if ($json = @json_decode($value, true)) {
                $value = $json;
            }
        }

        // Array
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = static::toDynamicType($val);
            }

            return $value;
        }

        return $value;
    }

    /**
     * @return bool
     */
    public function isArray()
    {
        return is_array($this->getValue());
    }

    /**
     * @return bool
     */
    public function isJson()
    {
        return false !== json_decode($this->getOriginalValue());
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        if ($this->isArray()) {
            return json_encode($this->getValue());
        }

        return (string)$this->getValue();
    }

    /**
     * @return array|null
     */
    public function jsonSerialize()
    {
        if ($this->isArray()) {
            return $this->getValue();
        }
    }
}