@extends('layouts.app')

@section('content')
<div class="container chapters-list-section">
    <h3>Capítulos e Rascunhos do Livro: {{ $livro->nome }}</h3>
    <div class="row">
        <div class="col-md-6">
            <h5>Capítulos Publicados</h5>
            <ul class="list-group">
                @foreach($capitulos as $cap)
                <li class="list-group-item">
                    <a href="{{ route('chapter.show', ['id'=>$cap->_id]) }}">{{ $cap->titulo }}</a>
                    <span class="text-muted">{{ $cap->updatedAt ?? '' }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <h5>Rascunhos</h5>
            <ul class="list-group">
                @foreach($rascunhos as $r)
                <li class="list-group-item">
                    {{ $r->titulo }}
                    <span class="text-muted">{{ $r->updatedAt ?? '' }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
