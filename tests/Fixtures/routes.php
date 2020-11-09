<?php

app('router')->get('/foo', function () {
});

app('router')->match(['PUT', 'PATCH'], '/bar', function () {
});

app('router')->get('/_ignition/baq', function () {
});

app('router')->get('/telescope/baw', function () {
});

app('router')->get('/_debugbar/bae', function () {
});

app('router')->get('summary', '\Tests\Fixtures\Controller@summary')->name('summary');
app('router')->get('description', '\Tests\Fixtures\Controller@description')->name('description');
app('router')->get('deprecated', '\Tests\Fixtures\Controller@deprecated')->name('deprecated');
app('router')->get('without', '\Tests\Fixtures\Controller@without')->name('without');
app('router')->get('withoutDeprecated', '\Tests\Fixtures\Controller@withoutDeprecated')->name('withoutDeprecated');
