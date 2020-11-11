<?php

namespace Helldar\LaravelRoutesCore\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Tag extends Arrayable
{
    public function getCode(): int;

    public function getClass(): string;

    public function getDescription(): ?string;
}
