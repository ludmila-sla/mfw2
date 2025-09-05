@extends('layouts.app')

@section('content')
<div class="container profile-section">
    <h3>Perfil do Usuário</h3>
    <p><strong>Nome:</strong> Lud</p>
    <p><strong>Email:</strong> lud@email.com</p>
    <h5>Meus Livros</h5>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
        @for ($i=1; $i<=3; $i++)
        <div class="col">
            <div class="card book-card">
                <img src="https://via.placeholder.com/150x200" alt="Capa do Livro">
                <div class="card-body">
                    <h5 class="card-title">Livro Meu {{ $i }}</h5>
                    <button class="btn btn-sm btn-primary" style="background-color:#6A0DAD;">Editar</button>
                    <button class="btn btn-sm btn-danger">Deletar</button>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
