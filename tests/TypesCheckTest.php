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
    }
}