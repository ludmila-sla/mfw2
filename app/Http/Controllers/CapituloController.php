<?php

namespace App\Http\Controllers;

use App\Http\Requests\capituloRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CapituloController extends Controller
{
    public function create(capituloRequest $request, $user = null)
    {
        $user = $user ?: Auth::user();
        if (!$user) return response(['error' => 'Não autenticado'], 401);

        $data = $request->all();
        $data['_id'] = 'capitulo_' . Str::uuid();
        $data['autor_id'] = $user->id;
        $data['autor_nome'] = $user->name;
        $data['createdAt'] = Carbon::now();
        $data['updatedAt'] = Carbon::now();
        $data['deletado'] = false;

        DB::table('capitulos')->insert($data);

        $paragrafos = preg_split("/\r\n|\n|\r/", $data['texto'] ?? '');
        foreach ($paragrafos as $ordem => $paragrafoTexto) {
            if (trim($paragrafoTexto) === '') continue;
            $paragrafo = [
                '_id' => 'paragrafo_' . Str::uuid(),
                'capitulo_id' => $data['_id'],
                'ordem' => $ordem,
                'texto' => $paragrafoTexto,
                'createdAt' => Carbon::now(),
                'updatedAt' => Carbon::now(),
                'deletado' => false
            ];
            DB::table('paragrafos')->insert($paragrafo);
        }

        return response([], 201);
    }

    public function edit($id, capituloRequest $request,  $user = null)
    {
        $user = Auth::user() ?? $user;
        if (!$user) return response(['error' => 'Não autenticado'], 401);

        $capitulo = DB::table('capitulos')
            ->where('_id', $id)
            ->where('deletado', '!=', true)
            ->first();

        if (!$capitulo) return response(['error' => 'Capítulo não encontrado'], 404);
        if ($capitulo->autor_id !== $user->id) return response(['error' => 'Sem permissão'], 403);

        $data = $request->all();
        $data['updatedAt'] = Carbon::now();

        DB::table('capitulos')->where('_id', $id)->update($data);

        return response([], 200);
    }

    public function delete($id,  $user = null)
    {
        $user = Auth::user() ?? $user;
        if (!$user) return response(['error' => 'Não autenticado'], 401);

        $capitulo = DB::table('capitulos')
            ->where('_id', $id)
            ->where('deletado', '!=', true)
            ->first();

        if (!$capitulo) return response(['error' => 'Capítulo não encontrado'], 404);
        if ($capitulo->autor_id !== $user->id) return response(['error' => 'Sem permissão'], 403);

        DB::table('capitulos')->where('_id', $id)->update([
            'deletado' => true,
            'deletadoAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);


        DB::table('paragrafos')->where('capitulo_id', $id)->update([
            'deletado' => true,
            'deletadoAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);

        return response([], 200);
    }

    public function list($autor_id, $livro_id,  $user = null)
    {
        $capitulos = DB::table('capitulos')
            ->where('autor_id', $autor_id)
            ->where('livro', $livro_id)
            ->where('deletado', '!=', true)
            ->get()
             ->map(function ($capitulo) {
            return (array) $capitulo;
        });

         $capituloIds = array_column($capitulos->toArray(), '_id');

        $paragrafos = DB::table('paragrafos')
            ->whereIn('capitulo_id', $capituloIds)
            ->where('deletado', '!=', true)
            ->orderBy('ordem')
            ->get()
            ->groupBy('capitulo_id');

         $capitulos = $capitulos->map(function ($capitulo) use ($paragrafos) {
        $capitulo['_id'] = $capitulo['_id'] ?? $capitulo['id'] ?? null; // garante que exista
        $capitulo['paragrafos'] = $paragrafos[$capitulo['_id']] ?? [];
        return $capitulo;
    });

        $user = Auth::user() ?? $user;
        $rascunhos = [];
        if ($user && $user->id == $autor_id) {
            $rascunhos = DB::table('rascunhos')
                ->where('autor_id', $autor_id)
                ->where('livro', $livro_id)
                ->get();
        }

        return response([
            'capitulos' => $capitulos,
            'rascunhos' => $rascunhos
        ], 200);
    }

    public function rascunho(capituloRequest $request,  $user = null)
    {
        $user = Auth::user() ?? $user;
        if (!$user) return response(['error' => 'Não autenticado'], 401);

        $data = $request->all();
        $data['_id'] = Str::uuid()->toString();
        $data['autor_id'] = $user->id;
        $data['autor_nome'] = $user->name;
        $data['createdAt'] = Carbon::now();
        $data['updatedAt'] = Carbon::now();

        DB::table('rascunhos')->insert($data);

        return response([], 201);
    }

    public function show($capitulo_id, $livro_id, $table)
    {
        $capitulo = DB::table($table)
            ->where('livro', $livro_id)
            ->where('_id', $capitulo_id)
            ->where('deletado', '!=', true)
            ->first();

        if (!$capitulo) return response(['error' => 'Capítulo não encontrado'], 404);

        if ($table === 'capitulos') {
            $leituras = DB::table('capitulos')->where('_id', $capitulo_id)->value('leituras') ?? 0;
            DB::table('capitulos')->where('_id', $capitulo_id)->update(['leituras' => $leituras + 1]);
        }

        return response()->json($capitulo, 200);
    }
}
