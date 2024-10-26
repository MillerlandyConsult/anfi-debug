<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug/{key}', [App\Http\Controllers\DebugController::class, 'showDebug']);

