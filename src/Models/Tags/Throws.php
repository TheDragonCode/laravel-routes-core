<?php

namespace Helldar\LaravelRoutesCore\Models\Tags;

use Helldar\LaravelRoutesCore\Contracts\Tag;
use Helldar\LaravelRoutesCore\Traits\Makeable;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\DocBlock\Tags\Throws as ThrowTag;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class Throws implements Tag
{
    use Makeable;

    public $class;

    public $description;

    public $code;

    public function __construct(ThrowTag $tag)
    {
        $this->setClass($tag);
        $this->setDescription($tag);
        $this->setCode();
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(ThrowTag $tag): void
    {
        $this->class = ltrim($tag->getType(), '\\');
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(ThrowTag $tag): void
    {
        $this->description = $tag->getDescription()->getBodyTemplate() ?? null;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(): void
    {
        $this->code = class_exists($this->getClass()) && is_subclass_of($this->getClass(), HttpException::class)
            ? 400
            : 500;
    }

    public function toArray()
    {
        return Arr::get($this->exceptions(), $this->getClass(), $this->getDefault());
    }

    protected function getDefault(): array
    {
        return [
            'code'        => $this->code,
            'description' => $this->description,
            'class'       => $this->class,
        ];
    }

    protected function exceptions(): array
    {
        return config('laravel-swagger.exceptions', []);
    }
}
