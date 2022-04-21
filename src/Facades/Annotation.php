<?php

namespace DragonCode\LaravelRoutesCore\Facades;

use DragonCode\LaravelRoutesCore\Models\Tags\Returns;
use DragonCode\LaravelRoutesCore\Models\Tags\Throws;
use DragonCode\LaravelRoutesCore\Support\Annotation as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null summary(string $controller, string $method = null)
 * @method static string|null description(string $controller, string $method = null)
 * @method static boolean isDeprecated(string $controller, string $method = null)
 * @method static Throws[] exceptions(string $controller, string $method = null)
 * @method static Returns[] response(string $controller, string $method = null)
 */
class Annotation extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Support::class;
    }
}
