<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DefinitionsController;
use App\Http\Controllers\QuestionsController;

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

// Routes pour le quiz
Route::get('/quiz/start', [QuestionsController::class, 'startQuiz'])->name('quiz.start');
Route::get('/quiz', [QuestionsController::class, 'quiz'])->name('quiz');
Route::post('/quiz/submit', [QuestionsController::class, 'submitAnswer'])->name('quiz.submit');
Route::get('/quiz/next', [QuestionsController::class, 'nextQuestion'])->name('quiz.next');
Route::get('/quiz/results', [QuestionsController::class, 'results'])->name('quiz.results');
Route::get('/quiz/reset', [QuestionsController::class, 'resetQuiz'])->name('quiz.reset');