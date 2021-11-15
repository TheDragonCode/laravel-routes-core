<?php

namespace DragonCode\LaravelRoutesCore\Models\Tags;

use DragonCode\Contracts\Routing\Core\Tag;
use DragonCode\LaravelRoutesCore\Traits\Makeable;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\DocBlock\Tag as DocTag;

abstract class BaseTag implements Tag
{
    use Makeable;

    public $code;

    public $class;

    public $description;

    protected $sources = [];

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

    abstract public function setCode(): void;

    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param  \phpDocumentor\Reflection\DocBlock\Tag  $tag
     */
    public function setClass(DocTag $tag): void
    {
        $this->class = ltrim($tag->getType(), '\\');
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    abstract public function setDescription(DocTag $tag): void;

    public function setSources(array $items): Tag
    {
        $this->sources = $items;

        return $this;
    }

    public function toArray()
    {
        return $this->getSource([
            'code'        => $this->code,
            'description' => $this->description,
            'class'       => $this->class,
        ]);
    }

    protected function getSource(array $default)
    {
        return Arr::get($this->sources, $this->getClass(), $default);
    }
}
