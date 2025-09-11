<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Requests\capituloRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\CapituloController;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CapituloControllerTest extends TestCase
{
    protected $user;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $userData = DB::connection('mongodb')->table('users')->find('user_d51d4a19-3703-4874-b048-551f85b3efa3');

        $this->user = new User((array) $userData);
        $this->user->exists = true;

        $this->controller = new CapituloController();
    }

    public function testCreateCapitulo()
    {
        $request = new capituloRequest([
            'livro' => 'livro1',
            'titulo' => 'Capítulo 1',
            'texto' => "askgnaoñvpdrghnpãerhgoẽrhg",
        ]);
        $response = $this->controller->create($request, $this->user);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testEditCapitulo()
    {
        $capitulo_id = 'capitulo_'.Str::uuid();
        DB::table('capitulos')->insert([
            '_id' => $capitulo_id,
            'livro' => 'livro1',
            'titulo' => 'Capítulo 2',
            'autor_id' => $this->user->id,
            'texto' => "askgnaoñvpdrghnpãerhgoẽrhg",
            'deletado' => false,
        ]);

        $request = new capituloRequest([
            'titulo' => 'Capítulo Editado'
        ]);

        $response = $this->controller->edit( $capitulo_id, $request, $this->user);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteCapitulo()
    {
        $capitulo_id = 'capitulo_'.Str::uuid();
        DB::table('capitulos')->insert([
            '_id' => $capitulo_id,
            'livro' => 'livro1',
            'titulo' => 'Capítulo 3',
            'autor_id' => $this->user->id,
            'texto' => "askgnaoñvpdrghnpãerhgoẽrhg",
            'deletado' => false,
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);

        $request = new capituloRequest();

        $response = $this->controller->delete( $capitulo_id, $this->user);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testListCapitulos()
    {

        $response = $this->controller->list($this->user->id, 'livro1', $this->user);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateRascunho()
    {
        $request = new capituloRequest([
            'livro' => 'livro1',
            'titulo' => 'Rascunho 1',
            'historia' => 'Texto do rascunho'
        ]);

        $response = $this->controller->rascunho($request, $this->user);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testShowCapitulo()
    {
        $capitulo_id = 'capitulo_'.Str::uuid();
        DB::table('capitulos')->insert([
            '_id' => $capitulo_id,
            'livro' => 'livro1',
            'titulo' => 'Capítulo 1',
            'autor_id' => $this->user->id,
            'deletado' => false,
            'leituras' => 0,
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);


        $response = $this->controller->show($capitulo_id, 'livro1', 'capitulos');

        $this->assertEquals(200, $response->getStatusCode());
    }
    public function tearDown(): void {
        DB::table('capitulos')->where('livro', 'livro1')->delete();
        DB::table('rascunhos')->where('livro', 'livro1')->delete();
        parent::tearDown();
    }
}
