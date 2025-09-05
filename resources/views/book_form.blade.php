@extends('layouts.app')

@section('content')
<div class="container form-section">
    <h3>Criar / Editar Livro</h3>
    <form>
        <input type="text" class="form-control" placeholder="Título do Livro">
        <textarea class="form-control" placeholder="Descrição" rows="4"></textarea>
        <select class="form-select">
            <option value="">Categoria</option>
            <option>Terror</option>
            <option>Fantasia</option>
            <option>Ficção</option>
        </select>
        <input type="text" class="form-control" placeholder="Tags (separadas por vírgula)">
        <button type="submit" class="btn btn-lg" style="background-color:#6A0DAD; color:#fff;">Salvar</button>
    </form>
</div>
@endsection
