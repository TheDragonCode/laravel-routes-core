<?php

namespace Helldar\LaravelRoutesCore\Traits;

trait Makeable
{
    /**
     * Creates a class instance.
     *
     * @param  mixed  ...$parameters
     *
     * @return static
     */
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }
}
