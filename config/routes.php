<?php

use App\Controllers\ProductsController;
use Core\Router\Route;

Route::get('/', [ProductsController::class, 'index'])->name('root');

Route::get('/products/new', [ProductsController::class, 'new'])->name('products.new');
Route::post('/products', [ProductsController::class, 'create'])->name('products.create');

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');


Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');

Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
