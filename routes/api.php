<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;


Route::prefix('authors')
    ->name('authors.')
    ->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('index');
        Route::get('/{id}', [AuthorController::class, 'show'])->name('show');
        Route::post('/', [AuthorController::class, 'store'])->name('store');
        Route::put('/{id}', [AuthorController::class, 'update'])->name('update');
        Route::delete('/{id}', [AuthorController::class, 'destroy'])->name('destroy');
    });

Route::prefix('books')
    ->name('books.')
    ->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('index');
        Route::get('/{id}', [BookController::class, 'show'])->name('show');
        Route::post('/', [BookController::class, 'store'])->name('store');
        Route::put('/{id}', [BookController::class, 'update'])->name('update');
        Route::delete('/{id}', [BookController::class, 'destroy'])->name('destroy');
    });
