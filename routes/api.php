<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\CapituloController;
use App\Http\Controllers\AvaliacaoController;

Route::post('/livros/create', [LivroController::class, 'create']);
Route::get('/livros/search', [LivroController::class, 'search']);
Route::delete('/livros/delete/{livro}', [LivroController::class, 'delete']);
Route::post('/livros/edit/{livro}', [LivroController::class, 'edit']);
Route::get('/livros/list/{user}', [LivroController::class, 'list']);
Route::get('/livros/show/{livro}', [LivroController::class, 'show']);

Route::post('/capitulo/create', [CapituloController::class, 'create']);
Route::post('/capitulo/rascunho', [CapituloController::class, 'rascunho']);
Route::delete('/capitulo/delete/{capitulo}', [CapituloController::class, 'delete']);
Route::post('/capitulo/edit/{capitulo}', [CapituloController::class, 'edit']);
Route::get('/capitulo/list/{autor}/{livro}', [CapituloController::class, 'list']);
Route::get('/capitulo/show/{capitulo}/{livro}/{tabela}', [CapituloController::class, 'show']);

Route::post('/avaliacao/create', [AvaliacaoController::class, 'create']);
Route::delete('/avaliacao/delete/{avaliacao}', [AvaliacaoController::class, 'delete']);
Route::get('/avaliacao/list/{avaliacao}/{onde}', [AvaliacaoController::class, 'list']);
