<?php

namespace Tests\Feature;


use App\Http\Requests\avaliacaoRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\AvaliacaoController;
use Carbon\Carbon;
use Tests\TestCase;


class avaliacoesTest extends TestCase
{
    protected $user;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $userData = DB::connection('mongodb')->table('users')->find('user_d51d4a19-3703-4874-b048-551f85b3efa3');

        $this->user = new User((array) $userData);
        $this->user->exists = true;

        $this->controller = new AvaliacaoController();
        DB::table('livros')->insert([
            '_id' => "livroTesteAVAliacao",
            'titulo' => 'livro2',
            "autor_id" => $this->user->id,
            'sinopse' => 'sgethedfgbsdrgerg',
            'descricao' => "askgnaoñvpdrghnpãerhgoẽrhg",
            'categoria' => 'ficção',
            'deletado' => false,
        ]);
    }

    public function testCreateAvaliacao()
    {
        $request = new avaliacaoRequest([
            "onde" => "livro",
            "onde_id" => "livroTesteAVAliacao",
        ]);
        $response = $this->controller->create($request, $this->user);

        $this->assertEquals(201, $response->getStatusCode());
    }



    public function testDeleteAvaliacao()
    {
         DB::table('avaliacoes')->insert([
            "onde" => "livro",
            "onde_id" => "livroTesteAVAliacao",
            '_id' => "idTesteAvaliacaoDelete",
            'user_id' => $this->user->id,
            'user_nome' => $this->user->name
        ]);
        $response = $this->controller->delete("idTesteAvaliacaoDelete", $this->user);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testListAvaliacao()
    {
        DB::table('avaliacoes')->insert([
            "onde" => "livro",
            "onde_id" => "livroTesteAVAliacao",
            '_id' => "idTesteAvaliacaoList",
            'user_id' => $this->user->id,
            'user_nome' => $this->user->name
        ]);

        $response = $this->controller->list("livroTesteAVAliacao", "livro");

        $this->assertEquals(200, $response->getStatusCode());
    }



    public function tearDown(): void
    {
        DB::table('livros')->where('_id', 'livroTesteAVAliacao')->delete();
        DB::table('avaliacoes')->where('onde_id', 'livroTesteAVAliacao')->delete();

        parent::tearDown();
    }
}
