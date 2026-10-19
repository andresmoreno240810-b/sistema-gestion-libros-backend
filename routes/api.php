<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LibroController;
use App\Http\Controllers\Api\PrestamoController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\EditorialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // CatÃ¡logo de libros: declarar opciones antes de la ruta dinÃ¡mica {libro}.
    Route::get('/libros/opciones', [LibroController::class, 'opciones']);
    Route::get('/libros', [LibroController::class, 'index']);
    Route::post('/libros', [LibroController::class, 'store']);
    Route::get('/libros/{libro}', [LibroController::class, 'show']);
    Route::put('/libros/{libro}', [LibroController::class, 'update']);
    Route::patch('/libros/{libro}', [LibroController::class, 'update']);
    Route::delete('/libros/{libro}', [LibroController::class, 'destroy']);

    Route::get('/prestamos/opciones', [PrestamoController::class, 'opciones']);
    Route::get('/prestamos', [PrestamoController::class, 'index']);
    Route::post('/prestamos', [PrestamoController::class, 'store']);

    Route::get('/prestamos/{prestamo}', [PrestamoController::class, 'show']);
    Route::put('/prestamos/{prestamo}', [PrestamoController::class, 'update']);
    Route::patch('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver']);

    // Categorías
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::post('/categorias', [CategoriaController::class, 'store']);
    Route::get('/categorias/{categoria}', [CategoriaController::class, 'show']);
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update']);
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy']);
    // Autores
    Route::get('/autores', [AutorController::class, 'index']);
    Route::post('/autores', [AutorController::class, 'store']);
    Route::get('/autores/{autor}', [AutorController::class, 'show']);
    Route::put('/autores/{autor}', [AutorController::class, 'update']);
    Route::patch('/autores/{autor}', [AutorController::class, 'update']);
    Route::delete('/autores/{autor}', [AutorController::class, 'destroy']);

        // Editoriales
    Route::get('/editoriales', [EditorialController::class, 'index']);
    Route::post('/editoriales', [EditorialController::class, 'store']);
    Route::get('/editoriales/{editorial}', [EditorialController::class, 'show']);
    Route::put('/editoriales/{editorial}', [EditorialController::class, 'update']);
    Route::patch('/editoriales/{editorial}', [EditorialController::class, 'update']);
    Route::delete('/editoriales/{editorial}', [EditorialController::class, 'destroy']);
});
