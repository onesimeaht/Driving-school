<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cours', function () {
    return view('cours');
});
Route::get('/quiz', function () {
    return view('quiz');
});
