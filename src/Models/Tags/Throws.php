<?php

namespace DragonCode\LaravelRoutesCore\Models\Tags;

use DragonCode\Support\Facades\Instances\Instance;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\Tags\Throws as DocThrows;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Throws extends BaseTag
{
    public function setDescription(DocThrows|Tag $tag): void
    {
        $this->description = $tag->getDescription()->getBodyTemplate() ?? null;
    }

    public function setCode(): void
    {
        $this->code = Instance::of($this->getClass(), HttpException::class) ? 400 : 500;
    }
}
