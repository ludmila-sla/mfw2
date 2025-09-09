<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CapituloControllerTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
  
        parent::setUp();
        // Cria um usuário fake para simular login
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }
    public function testCreateCapitulo()
    {
        $response = $this->postJson('/capitulos/create', [
            'livro' => 'livro1',
            'titulo' => 'Capítulo 1',
            'historia' => "Parágrafo 1\nParágrafo 2"
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('capitulos', [
            'titulo' => 'Capítulo 1',
            'autor_id' => $this->user->id
        ]);

        $this->assertDatabaseCount('paragrafos', 2);
    }
    public function testEditCapitulo()
    {
        $capitulo_id = 'capitulo_'.Str::uuid();
        DB::table('capitulos')->insert([
            '_id' => $capitulo_id,
            'livro' => 'livro1',
            'titulo' => 'Capítulo 1',
            'autor_id' => $this->user->id,
            'deletado' => false,
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);

        $response = $this->putJson("/capitulos/edit/{$capitulo_id}", [
            'titulo' => 'Capítulo Editado'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('capitulos', [
            '_id' => $capitulo_id,
            'titulo' => 'Capítulo Editado'
        ]);
    }
    public function testDeleteCapitulo()
    {
        $capitulo_id = 'capitulo_'.Str::uuid();
        DB::table('capitulos')->insert([
            '_id' => $capitulo_id,
            'livro' => 'livro1',
            'titulo' => 'Capítulo 1',
            'autor_id' => $this->user->id,
            'deletado' => false,
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);

        $response = $this->deleteJson("/capitulos/delete/{$capitulo_id}");

        $response->assertStatus(200);

        $this->assertDatabaseHas('capitulos', [
            '_id' => $capitulo_id,
            'deletado' => true
        ]);
    }
    public function testListCapitulos()
    {
        $capitulo_id = 'capitulo_'.Str::uuid();
        DB::table('capitulos')->insert([
            '_id' => $capitulo_id,
            'livro' => 'livro1',
            'titulo' => 'Capítulo 1',
            'autor_id' => $this->user->id,
            'deletado' => false,
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now()
        ]);

        $response = $this->getJson("/capitulos/list/{$this->user->id}/livro1");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'capitulos' => [['titulo', 'paragrafos']],
                     'rascunhos'
                 ]);
    }
    public function testCreateRascunho()
    {
        $response = $this->postJson('/capitulos/rascunho', [
            'livro' => 'livro1',
            'titulo' => 'Rascunho 1',
            'historia' => 'Texto do rascunho'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('rascunhos', [
            'titulo' => 'Rascunho 1',
            'autor_id' => $this->user->id
        ]);
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

        $response = $this->getJson("/capitulos/show/{$capitulo_id}/livro1/capitulos");

        $response->assertStatus(200);

        $this->assertDatabaseHas('capitulos', [
            '_id' => $capitulo_id,
            'leituras' => 1
        ]);
    }
}
