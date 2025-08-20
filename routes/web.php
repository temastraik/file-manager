<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\FileGroupController;
use Illuminate\Support\Facades\Route;

// Главная страница - список файлов
Route::get('/', [FileController::class, 'index'])->name('files.index');

// Маршруты для файлов
Route::prefix('files')->group(function () {
    Route::get('/create', [FileController::class, 'create'])->name('files.create');
    Route::post('/', [FileController::class, 'store'])->name('files.store');
    Route::get('/download/{file}', [FileController::class, 'download'])->name('files.download');
    Route::delete('/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/type/{type}', [FileController::class, 'byType'])->name('files.by-type');
});

// Маршруты для групп файлов
Route::prefix('file-groups')->group(function () {
    Route::get('/', [FileGroupController::class, 'index'])->name('file-groups.index');
    Route::get('/create', [FileGroupController::class, 'create'])->name('file-groups.create');
    Route::post('/', [FileGroupController::class, 'store'])->name('file-groups.store');
    Route::get('/{fileGroup}', [FileGroupController::class, 'show'])->name('file-groups.show');
    Route::delete('/{fileGroup}', [FileGroupController::class, 'destroy'])->name('file-groups.destroy');
});