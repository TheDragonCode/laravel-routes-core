<?php

namespace DragonCode\LaravelRoutesCore\Models\Tags;

use phpDocumentor\Reflection\DocBlock\Tag as DocTag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Returns extends BaseTag
{
    public function setDescription(DocTag $tag): void
    {
    }

    public function setCode(): void
    {
        $class = $this->getClass();

        if (is_subclass_of($class, JsonResponse::class)) {
            $this->code = 200;
        } elseif (is_subclass_of($class, HttpException::class)) {
            $this->code = 400;
        } else {
            $this->code = 500;
        }
    }
}
