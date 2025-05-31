<?php

use App\Controllers\ProductsController;
use Core\Router\Route;

Route::get('/', [ProductsController::class, 'index']);
Route::get('/products/new', [ProductsController::class, 'new']);
