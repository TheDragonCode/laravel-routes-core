<?php

namespace Tests\ExtendedTests;

use PHPUnit\Framework\ExpectationFailedException;

/** @mixin \Tests\TestCase */
trait Assert
{
    /**
     * Asserts that a variable is of type array.
     *
     * @psalm-assert array $actual
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
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
     * @psalm-assert int $actual
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
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
     * @psalm-assert string $actual
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public static function assertIsString($actual, string $message = ''): void
    {
        if (method_exists(parent::class, 'assertIsString')) {
            parent::assertIsString($actual, $message);
        } else {
            static::assertTrue(is_string($actual), $message);
        }
    }

    /**
     * Asserts that a variable is of type bool.
     *
     * @psalm-assert bool $actual
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public static function assertIsBool($actual, string $message = ''): void
    {
        if (method_exists(parent::class, 'assertIsBool')) {
            parent::assertIsBool($actual, $message);
        } else {
            static::assertTrue(is_bool($actual), $message);
        }
    }
}
