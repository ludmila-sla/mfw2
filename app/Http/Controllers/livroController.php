<?php

namespace App\Http\Controllers;

use App\Http\Requests\livroRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class livroController extends Controller
{
    public function create(livroRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['error' => 'Não autenticado'], 401);
        }

        $data = $request->all();
        $data['_id'] = "livro_" . Str::uuid();
        $data['autor_id'] = $user->id;
        $data['autor_nome'] = $user->name;
        $data['createdAt'] = Carbon::now();
        $data['updatedAt'] = Carbon::now();
        $data['deletado'] = false;

        DB::table('livros')->insert($data);

        return response([], 201);
    }

    public function edit($id, livroRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['error' => 'Não autenticado'], 401);
        }

        $livro = DB::table('livros')
            ->where('_id', $id)
            ->where('deletado', '!=', true)
            ->first();

        if (!$livro) {
            return response(['error' => 'Livro não encontrado'], 404);
        }

        if ($livro->autor_id !== $user->id) {
            return response(['error' => 'Sem permissão para editar este livro'], 403);
        }

        $data = $request->all();
        $data['updatedAt'] = Carbon::now();

        DB::table('livros')->where('_id', $id)->update($data);

        return response([], 200);
    }

    public function delete($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['error' => 'Não autenticado'], 401);
        }

        $livro = DB::table('livros')
            ->where('_id', $id)
            ->where('deletado', '!=', true)
            ->first();

        if (!$livro) {
            return response(['error' => 'Livro não encontrado'], 404);
        }

        if ($livro->autor_id !== $user->id) {
            return response(['error' => 'Sem permissão para excluir este livro'], 403);
        }

        DB::table('livros')->where('_id', $id)->update([
            'deletado'   => true,
            'deletadoAt' => Carbon::now(),
            'updatedAt'  => Carbon::now(),
        ]);

        return response([], 200);
    }

    public function list($autor_id)
    {
        $livros = DB::table('livros')
            ->where('autor_id', $autor_id)
            ->where('deletado', '!=', true)
            ->get();

        return response($livros, 200);
    }

    public function show($id)
    {
        $livro = DB::table('livros')
            ->where('_id', $id)
            ->where('deletado', '!=', true)
            ->first();

        return response($livro, $livro ? 200 : 404);
    }

    public function search(Request $request)
    {
        $query = DB::table('livros')->where('deletado', '!=', true);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('autor_nome', 'like', "%{$q}%")
                    ->orWhere('nome', 'like', "%{$q}%")
                    ->orWhere('descricao', 'like', "%{$q}%");
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->input('categoria'));
        }

        if ($request->filled('tags')) {
            $tags = $request->input('tags');
            $query->where(function ($sub) use ($tags) {
                foreach ($tags as $tag) {
                    $sub->orWhereJsonContains('tags', $tag);
                }
            });
        }

        $resultados = $query->get();
        return response($resultados, 200);
    }
}
