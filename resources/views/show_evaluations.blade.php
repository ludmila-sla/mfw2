@extends('layouts.app')

@section('content')
<div class="container evaluations-section">
    <h3>Avaliações</h3>

    <h5>Livro</h5>
    @foreach($avaliacoesLivro as $av)
    <div class="card mb-2 p-2">
        <strong>{{ $av->user_name }}</strong> - Nota: {{ $av->nota }} <br>
        {{ $av->comentario }}
    </div>
    @endforeach

    <h5>Capítulos</h5>
    @foreach($avaliacoesCap as $av)
    <div class="card mb-2 p-2">
        <strong>{{ $av->user_name }}</strong> - Nota: {{ $av->nota }} <br>
        {{ $av->comentario }}
    </div>
    @endforeach

    <h5>Parágrafos</h5>
    @foreach($avaliacoesPar as $av)
    <div class="card mb-2 p-2">
        <strong>{{ $av->user_name }}</strong> - Nota: {{ $av->nota }} <br>
        {{ $av->comentario }}
    </div>
    @endforeach
</div>
@endsection
