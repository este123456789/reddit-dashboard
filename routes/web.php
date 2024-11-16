<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\ThemeController;

// Ruta principal para el Dashboard
Route::get('/', function () {
    return view('dashboard');  // Este es el archivo Blade que creamos anteriormente
});

Route::get('themes', [ThemeController::class, 'index']);


// Otras rutas de la web si las necesitas, por ejemplo para el detalle del tema:
Route::get('/theme/{id}', [ThemeController::class, 'show'])->name('theme.show');

// Ruta para obtener y guardar los últimos 10 temas de Reddit
Route::get('/import-last-10-themes', [ThemeController::class, 'importLast10Themes']);
