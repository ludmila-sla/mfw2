@extends('layouts.app')

@section('content')
<div class="container search-section">
    <div class="row g-2">
        <div class="col-12 col-md-9">
            <input type="text" class="form-control form-control-lg" placeholder="Pesquisar livros, autores...">
        </div>
        <div class="col-12 col-md-3">
            <button class="btn btn-lg w-100" style="background-color: #6A0DAD; color:#fff;">Buscar</button>
        </div>
    </div>
    <div class="mt-3 d-flex flex-wrap gap-2">
        <select class="form-select" style="width: auto;">
            <option value="">Categoria</option>
            <option>Terror</option>
            <option>Fantasia</option>
            <option>Ficção</option>
        </select>
        <select class="form-select" style="width: auto;">
            <option value="">Ordenar por</option>
            <option>Mais lidos</option>
            <option>Mais recentes</option>
        </select>
    </div>
</div>

<div class="container category-section">
    <h3>Mais Lidos</h3>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
        @for ($i=1; $i<=4; $i++)
        <div class="col">
            <div class="card book-card">
                <img src="https://via.placeholder.com/150x200" alt="Capa do Livro">
                <div class="card-body">
                    <h5 class="card-title">Livro {{ $i }}</h5>
                    <p class="card-text">Autor {{ $i }}</p>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
