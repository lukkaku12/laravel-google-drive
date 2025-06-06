<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::middleware(['jwt.auth'])->prefix('files')->group(function () {
    Route::get('/', [FileController::class, 'index']); // Listar archivos del bucket
    Route::post('/', [FileController::class, 'store']);          // Subir archivo

    Route::get('/{path}', [FileController::class, 'show'])
        ->where('path', '.*');                                   // Obtener URL del archivo

    Route::delete('/{path}', [FileController::class, 'destroy'])
        ->where('path', '.*');                                   // Eliminar archivo
});