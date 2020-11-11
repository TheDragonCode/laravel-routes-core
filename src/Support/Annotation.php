<?php

namespace Helldar\LaravelRoutesCore\Support;

use Helldar\LaravelRoutesCore\Models\Reader;
use Helldar\LaravelRoutesCore\Models\Throws;
use phpDocumentor\Reflection\DocBlock;

final class Annotation
{
    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @return string|null
     */
    public function summary(string $controller, string $method = null): ?string
    {
        return $this->get(static function (DocBlock $doc) {
            return $doc->getSummary();
        }, $controller, $method);
    }

    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @return string|null
     */
    public function description(string $controller, string $method = null): ?string
    {
        return $this->get(static function (DocBlock $doc) {
            return $doc->getDescription()->getBodyTemplate();
        }, $controller, $method);
    }

    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @return bool
     */
    public function isDeprecated(string $controller, string $method = null)
    {
        return (bool) $this->get(static function (DocBlock $doc) {
            return $doc->hasTag('deprecated');
        }, $controller, $method);
    }

    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @return array|\phpDocumentor\Reflection\DocBlock\Tag[]
     */
    public function exceptions(string $controller, string $method = null): array
    {
        $callback = static function (DocBlock $doc) {
            return array_map(static function (DocBlock\Tags\Throws $tag) {
                return Throws::make($tag);
            }, $doc->getTagsByName('throws'));
        };

        $reader = $this->reader($controller, $method);

        $for_class  = $this->getValue($callback, $reader, 'forClass', []);
        $for_method = $this->getValue($callback, $reader, 'forMethod', []);

        return collect($for_class)
            ->merge(collect($for_method))
            ->unique('code')
            ->keyBy('code')
            ->filter()
            ->toArray();
    }

    protected function reader(string $controller, string $method = null): Reader
    {
        return Reader::make($controller, $method);
    }

    protected function get(callable $callback, string $controller, string $method = null)
    {
        $reader = $this->reader($controller, $method);

        return $this->getValue($callback, $reader, 'forMethod')
            ?: $this->getValue($callback, $reader, 'forClass');
    }

    protected function getValue(callable $callback, Reader $reader, string $method, $default = null)
    {
        if ($block = $reader->$method()) {
            if ($value = $callback($block)) {
                return $value;
            }
        }

        return $default;
    }
}
