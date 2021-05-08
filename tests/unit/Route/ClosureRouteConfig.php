<?php

use Webman\Route;
use Webman\Http\Request;

Route::get('/foo', function () {
    return 'get-foo';
});

Route::post('/foo', function () {
    return 'post-foo';
});

Route::put('/foo', function () {
    return 'put-foo';
});

Route::patch('/foo', function () {
    return 'patch-foo';
});

Route::delete('/foo', function () {
    return 'delete-foo';
});

Route::head('/foo', function () {
    return 'head-foo';
});

Route::options('/foo', function () {
    return 'options-foo';
});

Route::any('/any-foo', function (Request $request) {
    return strtolower($request->method()).'-any';
});