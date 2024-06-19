<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/contacts', [App\Http\Controllers\HomeController::class, 'index'])->name('contactpage');
Route::get('/thankyou', [App\Http\Controllers\HomeController::class, 'thankyou'])->name('thankyou');
Route::resource('contacts', \App\Http\Controllers\ContactController::class);
Route::get('/search', [App\Http\Controllers\ContactController::class, 'search'])->name('search');
