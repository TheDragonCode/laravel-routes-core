<?php

namespace Tests\ExtendedTests;

use PHPUnit\Framework\Constraint\IsType;

/** @mixin \Tests\TestCase */
trait Assert
{
    public static function assertIsArray($actual, string $message = ''): void
    {
        static::assertThat(
            $actual,
            new IsType(IsType::TYPE_ARRAY),
            $message
        );
    }

    public static function assertIsInt($actual, string $message = null): void
    {
        static::assertThat(
            $actual,
            new IsType(IsType::TYPE_INT),
            $message
        );
    }
}
