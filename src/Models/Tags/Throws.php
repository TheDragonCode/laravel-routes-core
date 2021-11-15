<?php

namespace DragonCode\LaravelRoutesCore\Models\Tags;

use phpDocumentor\Reflection\DocBlock\Tag as DocTag;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Throws extends BaseTag
{
    /**
     * @param  \phpDocumentor\Reflection\DocBlock\Tag|\phpDocumentor\Reflection\DocBlock\Tags\Throws  $tag
     */
    public function setDescription(DocTag $tag): void
    {
        $this->description = $tag->getDescription()->getBodyTemplate() ?? null;
    }

    public function setCode(): void
    {
        $this->code = class_exists($this->getClass()) && is_subclass_of($this->getClass(), HttpException::class)
            ? 400
            : 500;
    }
}
