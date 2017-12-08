<?php

namespace Tests\Feature;

use App\Example;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->mockUser();
    }

    public function testCreate()
    {
        $response = $this->post('/api/v1/examples', $data = [
            'foo' => 'bar',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['id']);

        $this->assertDatabaseHas('examples', array_merge([
            'id' => $response->json()['id'],
        ], $data));
    }

    public function testRead()
    {
        $example = factory(Example::class)->create();

        $response = $this->get("/api/v1/examples/{$example->id}");

        $response->assertStatus(200)->assertJson($example->refresh()->toArray());
    }

    public function testUpdate()
    {
        $example = factory(Example::class)->create([
            'foo' => 'bar'
        ]);

        $response = $this->put("/api/v1/examples/{$example->id}", $data = [
            'foo' => 'baz',
        ]);

        $response->assertStatus(200)->assertJson(['success' => true]);

        $this->assertDatabaseHas('examples', array_merge([
            'id' => $example->id,
        ], $data));
    }

    public function testDelete()
    {
        $example = factory(Example::class)->create();

        $response = $this->delete("/api/v1/examples/{$example->id}");

        $response->assertStatus(200)->assertJson(['success' => true]);

        $this->assertDatabaseMissing('examples', [
            'id' => $example->id,
        ]);
    }

    public function testList()
    {
        $examples = factory(Example::class, 15)->create();

        $response = $this->get('/api/v1/examples');

        $response->assertStatus(200)->assertJson($examples->map->refresh()->toArray());
    }
}
