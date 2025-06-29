<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrestamoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
    Route::get('/actualizar-datos', [AuthController::class, 'edit'])->name('actualizar.edit');
    Route::patch('/actualizar-datos', [AuthController::class, 'update'])->name('actualizar.update');

    Route::get('/products/comprar', [ProductController::class, 'comprar'])->name('products.comprar');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.index'); // agregado

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.index'); // <- ESTA es la que te falta


    Route::get('/prestamo', [PrestamoController::class, 'index'])->name('prestamo.index'); // Lista
    Route::get('/prestamo/create', [PrestamoController::class, 'create'])->name('prestamo.create'); // Formulario
    Route::post('/prestamo', [PrestamoController::class, 'store'])->name('prestamo.store'); // Guardar

    // routes/web.php
    Route::get('/prestamo/evaluacíon',[PrestamoController::class, 'tramitar'])->name('prestamo.tramitar');
    Route::patch('/prestamo/{id}/aprobar', [PrestamoController::class, 'aprobar'])->name('prestamo.aprobar');
    Route::patch('/prestamo/{id}/rechazar', [PrestamoController::class, 'rechazar'])->name('prestamo.rechazar');

    Route::post('/prestamo/simular', [PrestamoController::class, 'simular'])->name('prestamo.simular');
    Route::get('/prestamo/simular',[PrestamoController::class, 'index'])->name('prestamo.index');



    Route::get('/prestamo/simular-automatico',[PrestamoController::class, 'indexautomatico'])->name('prestamo.indexautomatico');
    Route::get('/prestamo/automatico-create', [PrestamoController::class, 'automaticocreate'])->name('prestamoautomatico.create'); 
    Route::post('/prestamo/simular-automatico', [PrestamoController::class, 'simularautomatico'])->name('prestamo.simularAutomatico');
    
    Route::post('/prestamo-automatico', [PrestamoController::class, 'automaticostore'])->name('prestamoautomatico.store'); // Guardar


    // Mostrar el formulario
    Route::get('/recarga', [App\Http\Controllers\RecargaController::class, 'show'])->name('recarga.form');

    // Ruta para autocompletar usuarios
    Route::get('/usuarios/buscar', [App\Http\Controllers\RecargaController::class, 'buscarUsuarios'])->name('usuarios.buscar');

    // Procesar la recarga
    Route::post('/recarga', [App\Http\Controllers\RecargaController::class, 'procesar'])->name('recarga.procesar');





});
