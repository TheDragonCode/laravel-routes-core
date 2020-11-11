<?php

namespace Helldar\LaravelRoutesCore\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use phpDocumentor\Reflection\DocBlock\Tag as DocTag;

interface Tag extends Arrayable
{
    public function getCode(): int;

    public function setCode(): void;

    public function getClass(): string;

    public function setClass(DocTag $tag): void;

    public function getDescription(): ?string;

    public function setDescription(DocTag $tag): void;

    public function setSources(array $items): self;
}
