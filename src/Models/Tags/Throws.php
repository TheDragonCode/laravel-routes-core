<?php

namespace Helldar\LaravelRoutesCore\Models\Tags;

use phpDocumentor\Reflection\DocBlock\Tag as DocTag;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class Throws extends BaseTag
{
    /**
     * @param  \phpDocumentor\Reflection\DocBlock\Tags\Throws|\phpDocumentor\Reflection\DocBlock\Tag  $tag
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
