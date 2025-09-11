<?php

namespace App\Http\Controllers;

use App\Http\Requests\avaliacaoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function create(avaliacaoRequest $request, $user = null)
    {
        $user = Auth::user() ?? $user;
        if (!$user) {
            return response(['error' => 'Não autenticado'], 401);
        }

        $data = $request->all();
        $data['_id'] = Str::uuid()->toString();
        $data['user_id'] = $user->id;
        $data['user_nome'] = $user->name;

        DB::table('avaliacoes')->insert($data);

        return response([], 201);
    }

    public function delete($id, $user = null)
    {
        $user = Auth::user() ?? $user;
        if (!$user) {
            return response(['error' => 'Não autenticado'], 401);
        }

        $avaliacao = DB::table('avaliacoes')->where('_id', $id)->first();

        if (!$avaliacao) {
            return response(['error' => 'Avaliação não encontrada'], 404);
        }

        if ($avaliacao->user_id !== $user->id) {
            return response(['error' => 'Sem permissão'], 403);
        }

        DB::table('avaliacoes')->where('_id', $id)->delete();

        return response([], 200);
    }

    public function list($id, $onde)
    {
        $avaliacoes = DB::table('avaliacoes')
            ->where('onde', $onde)
            ->where('onde_id', $id)
            ->get();

        return response($avaliacoes, 200);
    }
}
