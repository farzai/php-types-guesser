<?php namespace Farzai\Guesser;

use Farzai\Guesser\Expression\Expression;
use Farzai\Guesser\Expression\UseValue;
use JsonSerializable;
use Farzai\Guesser\Types;

class TypeGuesser implements JsonSerializable
{
    /**
     * Support types
     *
     * @var string[]
     */
    private $casts = [
        Types\NullType::class,
        Types\NumericType::class,
        Types\BooleanType::class,
        Types\JsonType::class,
    ];

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
        $instance = new static;

        foreach ($instance->casts as $type) {
            $value = (new $type)->cast($value);

            if ($value instanceof Expression) {
                $expression = $value;

                $value = $value->resolve();

                if ($expression instanceof UseValue) {
                    return $value;
                }
            }
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
        return gettype($this->getValue()) === 'integer';
    }

    /**
     * @return bool
     */
    public function isFloat()
    {
        return in_array(gettype($this->getValue()), ['float', 'double']);
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