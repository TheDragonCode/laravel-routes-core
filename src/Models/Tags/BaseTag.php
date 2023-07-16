<?php

namespace DragonCode\LaravelRoutesCore\Models\Tags;

use DragonCode\Contracts\Routing\Core\Tag;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\DocBlock\Tag as DocTag;

abstract class BaseTag implements Tag
{
    use Makeable;

    public int $code;

    public string $class;

    public ?string $description;

    protected array $sources = [];

    abstract public function setCode(): void;

    abstract public function setDescription(DocTag $tag): void;

    public function __construct(DocTag $tag)
    {
        $this->setClass($tag);
        $this->setDescription($tag);
        $this->setCode();
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(DocTag $tag): void
    {
        $this->class = Str::ltrim($tag->getType(), '\\');
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setSources(array $items): Tag
    {
        $this->sources = $items;

        return $this;
    }

    public function toArray(): array
    {
        return $this->getSource([
            'code'        => $this->code,
            'description' => $this->description,
            'class'       => $this->class,
        ]);
    }

    protected function getSource(array $default): array
    {
        return Arr::get($this->sources, $this->getClass(), $default);
    }
}
