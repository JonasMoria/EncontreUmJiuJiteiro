<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint não encontrado.',
    ], 404);
});
