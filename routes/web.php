<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['error' => 'This is an API-only application. Use the /api endpoint.'], 403);
});