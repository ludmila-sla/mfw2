<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\capituloController;
use App\Http\Controllers\avaliacaoController;

Route::post('/livros/create', [LivroController::class, 'create']);
Route::get('/livros/search', [LivroController::class, 'search']);
Route::delete('/livros/delete/{livro}', [LivroController::class, 'delete']);
Route::post('/livros/edit/{livro}', [LivroController::class, 'edit']);
Route::get('/livros/list/{user}', [LivroController::class, 'list']);
Route::get('/livros/show/{livro}', [LivroController::class, 'show']);

Route::post('/capitulo/create', [capituloController::class, 'create']);
Route::post('/capitulo/rascunho', [capituloController::class, 'rascunho']);
Route::delete('/capitulo/delete/{capitulo}', [capituloController::class, 'delete']);
Route::post('/capitulo/edit/{capitulo}', [capituloController::class, 'edit']);
Route::get('/capitulo/list/{autor}/{livro}', [capituloController::class, 'list']);
Route::get('/capitulo/show/{capitulo}/{livro}/{tabela}', [capituloController::class, 'show']);

Route::post('/avaliacao/create', [avaliacaoController::class, 'create']);
Route::delete('/avaliacao/delete/{avaliacao}', [avaliacaoController::class, 'delete']);
Route::get('/avaliacao/list/{avaliacao}/{onde}', [avaliacaoController::class, 'list']);
