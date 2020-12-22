<?php

namespace Tests\ExtendedTests;

use PHPUnit\Framework\ExpectationFailedException;

/** @mixin \Tests\TestCase */
trait Assert
{
    /**
     * Asserts that a variable is of type array.
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @psalm-assert array $actual
     */
    public static function assertIsArray($actual, string $message = ''): void
    {
        if (method_exists(parent::class, 'assertIsArray')) {
            parent::assertIsArray($actual, $message);
        } else {
            static::assertTrue(is_array($actual), $message);
        }
    }

    /**
     * Asserts that a variable is of type int.
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @psalm-assert int $actual
     */
    public static function assertIsInt($actual, string $message = ''): void
    {
        if (method_exists(parent::class, 'assertIsInt')) {
            parent::assertIsInt($actual, $message);
        } else {
            static::assertTrue(is_int($actual), $message);
        }
    }

    /**
     * Asserts that a variable is of type string.
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @psalm-assert string $actual
     */
    public static function assertIsString($actual, string $message = ''): void
    {
        if (method_exists(parent::class, 'assertIsString')) {
            parent::assertIsString($actual, $message);
        } else {
            static::assertTrue(is_string($actual), $message);
        }
    }
}
