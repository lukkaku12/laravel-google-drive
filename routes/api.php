<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->middleware('api')
    ->group(base_path('routes/auth.php'));

Route::middleware(['jwt.auth'])->group(base_path('routes/files.php'));

// Route::middleware(['jwt.auth'])->get('/user', function (Request $request) {
//     return $request->user();
// });
