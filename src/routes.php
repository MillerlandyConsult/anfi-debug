<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug/{key}', [ANFI\DebugPackage\DebugController::class, 'showDebug']);


