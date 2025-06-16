<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;

Route::prefix('products')->group(function () {
   Route::get('/', [ProductController::class, 'index'])->name('product');
});

Route::prefix('clients')->group(function () {
   Route::get('/', [ClientController::class, 'index'])->name('client');
});