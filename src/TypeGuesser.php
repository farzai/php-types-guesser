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
            $json = @json_decode($value, true);
            if (is_array($json)) {
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
    public function isString()
    {
        return is_string($this->getValue()) || $this->isJson();
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
        if (! is_string($this->getOriginalValue())) {
            return false;
        }

        return null !== @json_decode($this->getOriginalValue());
    }

    /**
     * @return bool
     */
    public function isBoolean()
    {
        return is_bool($this->getValue());
    }

    /**
     * @return bool
     */
    public function isNumeric()
    {
        return is_numeric($this->getValue());
    }

    /**
     * @return bool
     */
    public function isInteger()
    {
        if ($this->isNumeric()) {
            return gettype($this->getValue()) === 'integer';
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isFloat()
    {
        if ($this->isNumeric()) {
            return in_array(gettype($this->getValue()), ['float', 'double']);
        }

        return false;
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
