<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/quiz', function () {
    return view('quiz');
});
