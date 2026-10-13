<?php

use App\Models\Libro;
use App\Models\Categoria;
use App\Models\Prestamo;
use App\Models\User;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\PrestamoController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $totalLibros = Libro::count();
    $totalCategorias = Categoria::count();
    $totalPrestamos = Prestamo::count();
    $totalUsuarios = User::count();

    return view('dashboard', [
        'totalLibros' => $totalLibros,
        'totalCategorias' => $totalCategorias,
        'totalPrestamos' => $totalPrestamos,
        'totalUsuarios' => $totalUsuarios,
    ]);

})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Rutas para Administrador
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Administrador'])->group(function () {

    Route::resource('categorias', CategoriaController::class);

    Route::resource('autores', AutorController::class)
        ->parameters(['autores' => 'autor']);

    Route::resource('libros', LibroController::class);

    Route::resource('editorials', EditorialController::class);

    Route::resource('prestamos', PrestamoController::class);

    Route::patch(
        'prestamos/{prestamo}/devolver',
        [PrestamoController::class, 'devolver']
    )->name('prestamos.devolver');
});


/*
|--------------------------------------------------------------------------
| Rutas protegidas para usuarios autenticados
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';