<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meu Sistema de Ebooks</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body { font-family: 'Poppins', sans-serif; background-color: #f8f8f8; }
.navbar { background-color: #6A0DAD; }
.navbar .navbar-brand, .navbar .nav-link, .navbar .dropdown-toggle { color: #fff; }
.search-section, .chapter-section, .profile-section, .form-section { background-color: #fff; padding: 30px; border-radius:12px; margin-top:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1);}
.book-card { border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1); transition: transform 0.2s; cursor:pointer; }
.book-card:hover { transform: translateY(-5px); box-shadow:0 6px 15px rgba(0,0,0,0.15);}
.book-card img { width:100%; height:200px; object-fit:cover; }
.chapter-section .rating-btn { background-color: #6A0DAD; color:#fff; border:none; border-radius:8px; padding:5px 10px; margin-right:5px; transition: background 0.2s; }
.chapter-section .rating-btn:hover { background-color:#8A2BE2; }
</style>
</head>
<body>
@include('layouts.header')

@yield('content')

@include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
