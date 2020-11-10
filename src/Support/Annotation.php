<?php

namespace Helldar\LaravelRoutesCore\Support;

use Helldar\LaravelRoutesCore\Models\Reader;
use phpDocumentor\Reflection\DocBlock;

final class Annotation
{
    /**
     * @param  string  $controller
     * @param  string|null  $method
     *
     * @throws \ReflectionException
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
     * @throws \ReflectionException
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
     * @throws \ReflectionException
     *
     * @return bool
     */
    public function isDeprecated(string $controller, string $method = null)
    {
        return (bool) $this->get(static function (DocBlock $doc) {
            return $doc->hasTag('deprecated');
        }, $controller, $method);
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

    protected function getValue(callable $callback, Reader $reader, string $method)
    {
        if ($block = $reader->$method()) {
            if ($value = $callback($block)) {
                return $value;
            }
        }

        return null;
    }
}
