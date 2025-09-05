@extends('layouts.app')

@section('content')
<div class="container chapter-section">
    <h3>Capítulo 1: A Chegada</h3>
    @for ($i=1; $i<=3; $i++)
    <p>Parágrafo {{ $i }} do capítulo. <button class="rating-btn">Curtir</button> <button class="rating-btn">⭐</button></p>
    @endfor
</div>
@endsection
