<?php

app('router')->get('/foo', function () {});

app('router')->match(['PUT', 'PATCH'], '/bar', function () {});

app('router')->get('/_ignition/baq', function () {});

app('router')->get('/telescope/baw', function () {});

app('router')->get('/_debugbar/bae', function () {});

app('router')->get('summary', '\Tests\Fixtures\Controller@summary')->name('summary');
app('router')->get('description', '\Tests\Fixtures\Controller@description')->name('description');
app('router')->get('deprecated', '\Tests\Fixtures\Controller@deprecated')->name('deprecated');
app('router')->get('without', '\Tests\Fixtures\Controller@without')->name('without');
app('router')->get('withoutDeprecated', '\Tests\Fixtures\Controller@withoutDeprecated')->name('withoutDeprecated');
app('router')->get('incorrectDocBlock', '\Tests\Fixtures\Controller@incorrectDocBlock')->name('incorrectDocBlock');

app('router')
    ->middleware('api')
    ->get('routeApiMiddleware', '\Tests\Fixtures\Controller@routeApiMiddleware')
    ->name('routeApiMiddleware');

app('router')
    ->get('controllerApiMiddleware', '\Tests\Fixtures\Controller@controllerApiMiddleware')
    ->name('controllerApiMiddleware');

app('router')
    ->middleware('web')
    ->get('routeWebMiddleware', '\Tests\Fixtures\Controller@routeWebMiddleware')
    ->name('routeWebMiddleware');

app('router')
    ->get('controllerWebMiddleware', '\Tests\Fixtures\Controller@controllerWebMiddleware')
    ->name('controllerWebMiddleware');

app('router')
    ->get('closureNullName', static function () {});

app('router')
    ->get('closure', static function () {})->name('closure');
