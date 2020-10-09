<?php

namespace Tests;

use Farzai\Guesser\TypeGuesser;
use PHPUnit\Framework\TestCase;

class TypesCheckTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testString()
    {
        $value = 'test';

        $guesser = TypeGuesser::of($value);

        $this->assertTrue(is_string($guesser->getValue()));
        $this->assertEquals($value, (string)$guesser);
        $this->assertTrue($guesser->isString());
        $this->assertEquals($value, $guesser->getValue());
    }


    public function testJson()
    {
        $json = json_encode([
            'foo' => 'im string',
            'bar' => 1,
            'data' => [1, 2, 3]
        ]);

        $guesser = TypeGuesser::of($json);

        $this->assertIsArray($guesser->getValue());
        $this->assertTrue($guesser->isJson());
        $this->assertEquals($json, (string)$guesser);


        $array = [
            'foo' => 'im string',
            'bar' => 1,
            'data' => [1, 2, 3]
        ];
        $guesser = TypeGuesser::of($array);
        $this->assertIsArray($guesser->getValue());
        $this->assertFalse($guesser->isJson());
        $this->assertEquals(json_encode($array), (string)$guesser);
    }


    public function testBoolean()
    {
        $value = true;
        $guesser = TypeGuesser::of($value);
        $this->assertTrue($guesser->isBoolean());
        $this->assertTrue($guesser->getValue());

        $value = false;
        $guesser = TypeGuesser::of($value);
        $this->assertTrue($guesser->isBoolean());
        $this->assertFalse($guesser->getValue());

        $value = "true";
        $guesser = TypeGuesser::of($value);
        $this->assertTrue($guesser->isBoolean());
        $this->assertTrue($guesser->getValue());

        $value = "false";
        $guesser = TypeGuesser::of($value);
        $this->assertTrue($guesser->isBoolean());
        $this->assertFalse($guesser->getValue());

        $value = "test";
        $guesser = TypeGuesser::of($value);
        $this->assertFalse($guesser->isBoolean());
    }


    public function testNumeric()
    {
        $value = "2";
        $guesser = TypeGuesser::of($value);
        $this->assertTrue($guesser->isNumeric());
        $this->assertTrue($guesser->isInteger());
        $this->assertEquals(2, $guesser->getValue());

        $value = "1.2";
        $guesser = TypeGuesser::of($value);
        $this->assertTrue($guesser->isNumeric());
        $this->assertFalse($guesser->isInteger());
        $this->assertTrue($guesser->isFloat());
        $this->assertEquals(1.2, $guesser->getValue());

        $value = 2;
        $guesser = TypeGuesser::of($value);
        $this->assertTrue($guesser->isNumeric());
        $this->assertTrue($guesser->isInteger());
        $this->assertEquals(2, $guesser->getValue());

        $value = 1.2;
        $guesser = TypeGuesser::of($value);
        $this->assertTrue($guesser->isNumeric());
        $this->assertFalse($guesser->isInteger());
        $this->assertTrue($guesser->isFloat());
        $this->assertEquals(1.2, $guesser->getValue());
    }
}