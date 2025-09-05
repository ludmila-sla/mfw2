<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">LogoAqui</a>
        <div class="dropdown ms-auto">
            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">Perfil</button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile') }}">Meus Livros</a></li>
                <li><a class="dropdown-item" href="{{ route('book.form') }}">Criar Livro</a></li>
                <li><a class="dropdown-item" href="{{ route('profile') }}">Editar Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
