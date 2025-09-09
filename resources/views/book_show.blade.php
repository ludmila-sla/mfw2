@extends('layouts.app')

@section('content')
<div class="container book-show-section">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ $livro->capa ?? 'https://via.placeholder.com/300x400' }}" class="img-fluid rounded" alt="Capa do Livro">
        </div>
        <div class="col-md-8">
            <h2>{{ $livro->nome }}</h2>
            <p><strong>Autor:</strong> {{ $livro->autor }}</p>
            <p>{{ $livro->descricao }}</p>
            <h4>Capítulos</h4>
            <ul class="list-group">
                @foreach($capitulos as $cap)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('chapter.show', ['id' => $cap->_id]) }}">{{ $cap->titulo }}</a>
                        @if($cap->status == 'rascunho')
                            <span class="badge bg-secondary">Rascunho</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
