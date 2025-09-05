@extends('layouts.app')

@section('content')
<div class="container form-section">
    <h3>Criar / Editar Capítulo</h3>
    <form method="POST" action="{{ route('chapter.save') }}">
        @csrf
        <input type="hidden" name="capitulo_id" value="{{ $capitulo->_id ?? '' }}">
        <input type="hidden" name="livro_id" value="{{ $livro_id ?? '' }}">
        <input type="hidden" name="status" id="status" value="publicado">

        <div class="mb-3">
            <label for="titulo" class="form-label">Título do Capítulo</label>
            <input type="text" class="form-control" name="titulo" id="titulo" value="{{ $capitulo->titulo ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="editor" class="form-label">Conteúdo</label>
            <textarea id="editor" name="texto">{{ $capitulo->texto ?? '' }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary" onclick="setStatusAndSubmit('rascunho')">Salvar como Rascunho</button>
            <button type="button" class="btn btn-primary" onclick="setStatusAndSubmit('publicado')">Publicar</button>
        </div>
    </form>
</div>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
  selector: '#editor',
  height: 400,
  menubar: false,
  plugins: 'lists link image code',
  toolbar: 'undo redo | formatselect | bold italic underline | bullist numlist | link image | code'
});

// Função para definir status antes de enviar
function setStatusAndSubmit(status) {
    document.getElementById('status').value = status;
    document.querySelector('form').submit();
}
</script>
@endsection
