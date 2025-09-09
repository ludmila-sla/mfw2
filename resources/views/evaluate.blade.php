@extends('layouts.app')

@section('content')
<div class="container evaluate-section">
    <h3>Avaliar</h3>
    <form method="POST" action="{{ route('evaluate.save') }}">
        @csrf
        <input type="hidden" name="tipo" value="{{ $tipo }}"> <!-- livro, capitulo ou paragrafo -->
        <input type="hidden" name="onde_id" value="{{ $onde_id }}">

        <div class="mb-3">
            <label for="nota" class="form-label">Nota (1-5)</label>
            <select name="nota" id="nota" class="form-select" required>
                <option value="">Escolha...</option>
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="comentario" class="form-label">Comentário</label>
            <textarea name="comentario" id="comentario" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="background-color:#6A0DAD;">Enviar Avaliação</button>
    </form>
</div>
@endsection
