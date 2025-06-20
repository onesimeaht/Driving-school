<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DefinitionsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route pour la page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Route pour afficher les cours/définitions
Route::get('/cours', [DefinitionsController::class, 'index'])->name('cours.index');

// Routes supplémentaires (optionnelles) :
Route::get('/definitions/{id}', [DefinitionsController::class, 'show'])->name('definitions.show');

// Si vous voulez toutes les routes CRUD, utilisez plutôt :
// Route::resource('definitions', DefinitionsController::class);