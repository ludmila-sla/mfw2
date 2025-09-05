<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function(){ return view('home'); })->name('home');
Route::get('/chapter', function(){ return view('chapters'); })->name('chapter');
Route::get('/profile', function(){ return view('profile'); })->name('profile');
Route::get('/book/form', function(){ return view('book_form'); })->name('book.form');



require __DIR__.'/auth.php';
