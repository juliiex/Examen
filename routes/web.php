<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return redirect()->route('productos.index');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {

    Route::get(
        '/productos/buscar',
        [ProductoController::class, 'buscar']
    )->name('productos.buscar');

    Route::resource('productos', ProductoController::class);

    Route::get(
        '/categorias',
        [CategoriaController::class, 'index']
    )->name('categorias.index');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
