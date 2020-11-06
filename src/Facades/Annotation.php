<?php

namespace Helldar\LaravelRoutesCore\Facades;

use Helldar\LaravelRoutesCore\Support\Annotation as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null summary(string $controller, string $method = null)
 * @method static string|null description(string $controller, string $method = null)
 * @method static boolean isDeprecated(string $controller, string $method = null)
 * @method static boolean isDeprecatedClass(string $controller)
 * @method static boolean isDeprecatedMethod(string $controller, string $method)
 */
final class Annotation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
