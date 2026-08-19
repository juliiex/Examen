<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return redirect()->route('productos.index');
});

Route::get(
    '/productos/buscar',
    [ProductoController::class, 'buscar']
)->name('productos.buscar');

Route::resource('productos', ProductoController::class);
