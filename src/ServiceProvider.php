<?php

namespace Helldar\LaravelRoutesCore;

use Illuminate\Support\Str;

final class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->registerStrBefore();
        $this->registerStrAfter();
    }

    protected function registerStrBefore(): void
    {
        if (! method_exists(Str::class, 'before')) {
            Str::macro('before', static function ($subject, $search) {
                if ($search === '') {
                    return $subject;
                }

                $result = strstr($subject, (string) $search, true);

                return $result === false ? $subject : $result;
            });
        }
    }

    protected function registerStrAfter()
    {
        if (! method_exists(Str::class, 'after')) {
            Str::macro('after', static function ($subject, $search) {
                return $search === '' ? $subject : array_reverse(explode($search, $subject, 2))[0];
            });
        }
    }
}
