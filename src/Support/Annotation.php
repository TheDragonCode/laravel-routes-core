<?php

namespace DragonCode\LaravelRoutesCore\Support;

use DragonCode\LaravelRoutesCore\Models\Reader;
use DragonCode\LaravelRoutesCore\Models\Tags\Returns;
use DragonCode\LaravelRoutesCore\Models\Tags\Throws;
use DragonCode\Support\Facades\Instances\Instance;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\DocBlock\Tags\Throws as DocThrows;

class Annotation
{
    public function summary(string $controller, ?string $method = null): ?string
    {
        return $this->get(static function (DocBlock $doc) {
            return $doc->getSummary();
        }, $controller, $method);
    }

    public function description(string $controller, ?string $method = null): ?string
    {
        return $this->get(static function (DocBlock $doc) {
            return $doc->getDescription()->getBodyTemplate();
        }, $controller, $method);
    }

    public function isDeprecated(string $controller, ?string $method = null): bool
    {
        return (bool) $this->get(static fn (DocBlock $doc) => $doc->hasTag('deprecated'), $controller, $method);
    }

    /**
     * @return array<\DragonCode\LaravelRoutesCore\Models\Tags\Throws>|\Illuminate\Support\Collection
     */
    public function exceptions(string $controller, ?string $method = null): Collection
    {
        $callback = fn (DocBlock $doc) => array_map(static fn (DocThrows $tag) => Throws::make($tag), $this->getTagsByName($doc, 'throws'));

        $reader = $this->reader($controller, $method);

        $for_class  = $this->getValue($callback, $reader, 'forClass', []);
        $for_method = $this->getValue($callback, $reader, 'forMethod', []);

        return collect($for_class)
            ->merge(collect($for_method))
            ->unique('code')
            ->keyBy('code')
            ->sortBy('code')
            ->filter();
    }

    public function response(string $controller, ?string $method = null)
    {
        return $this->get(function (DocBlock $doc) {
            $returns = array_map(static fn (Return_ $tag) => Returns::make($tag), $this->getTagsByName($doc, 'return'));

            return Arr::first($returns);
        }, $controller, $method);
    }

    protected function reader(string $controller, ?string $method = null): Reader
    {
        return Reader::make($controller, $method);
    }

    protected function get(callable $callback, string $controller, ?string $method = null)
    {
        $reader = $this->reader($controller, $method);

        return $this->getValue($callback, $reader, 'forMethod')
            ?: $this->getValue($callback, $reader, 'forClass');
    }

    protected function getValue(callable $callback, Reader $reader, string $method, $default = null)
    {
        if ($block = $reader->{$method}()) {
            if ($value = $callback($block)) {
                return $value;
            }
        }

        return $default;
    }

    protected function getTagsByName(DocBlock $doc, string $name): array
    {
        return array_filter($doc->getTagsByName($name), static function ($tag) {
            return ! Instance::of($tag, InvalidTag::class);
        });
    }
}
