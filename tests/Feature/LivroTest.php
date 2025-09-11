<?php

namespace Tests\Feature;

use App\Http\Requests\livroRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\LivroController;
use Carbon\Carbon;
use Tests\TestCase;

class LivroTest extends TestCase
{

    protected $user;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $userData = DB::connection('mongodb')->table('users')->find('user_d51d4a19-3703-4874-b048-551f85b3efa3');

        $this->user = new User((array) $userData);
        $this->user->exists = true;

        $this->controller = new LivroController();
    }

    public function testCreateLivro()
    {
        $request = new livroRequest([
            'titulo' => 'livro1',
            'sinopse' => 'sgethedfgbsdrgerg',
            'descricao' => "askgnaoñvpdrghnpãerhgoẽrhg",
            'categoria' => 'ficção'
        ]);
        $response = $this->controller->create($request, $this->user);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testEditLivro()
    {
        DB::table('livros')->insert([
            '_id' => "livroTesteEdit",
            'titulo' => 'livro2',
            "autor_id" => $this->user->id,
            'sinopse' => 'sgethedfgbsdrgerg',
            'descricao' => "askgnaoñvpdrghnpãerhgoẽrhg",
            'categoria' => 'ficção',
            'deletado' => false,
        ]);

        $request = new livroRequest([
            'titulo' => 'Capítulo Editado'
        ]);

        $response = $this->controller->edit("livroTesteEdit", $request, $this->user);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteLivro()
    {
        DB::table('livros')->insert([
            '_id' => "livroTesteDelete",
            'titulo' => 'livro3',
            "autor_id" => $this->user->id,
            'sinopse' => 'sgethedfgbsdrgerg',
            'descricao' => "askgnaoñvpdrghnpãerhgoẽrhg",
            'categoria' => 'ficção',
            'deletado' => false,
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);


        $response = $this->controller->delete("livroTesteDelete", $this->user);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testListLivro()
    {

        $response = $this->controller->list($this->user->id);

        $this->assertEquals(200, $response->getStatusCode());
    }


    public function testShowLivro()
    {
        DB::table('livros')->insert([
            '_id' => 'livroteste1',
             'titulo' => 'livro5',
            'sinopse' => 'sgethedfgbsdrgerg',
            'descricao' => "askgnaoñvpdrghnpãerhgoẽrhg",
            'categoria' => 'ficção',
            'deletado' => false,
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);


        $response = $this->controller->show( "livroteste1");

        $this->assertEquals(200, $response->getStatusCode());
    }
    public function tearDown(): void {
        DB::table('livros')->where('_id', 'livroTesteEdit')->delete();
        DB::table('livros')->where('_id', 'livroTesteDelete')->delete();
        DB::table('livros')->where('_id', 'livroteste1')->delete();
        DB::table('livros')->where('sinopse', 'sgethedfgbsdrgerg')->delete();
        parent::tearDown();
    }
}
