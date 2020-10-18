<?php

namespace Tests\Feature;

use App\City;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndex()
    {
        $states = factory(City::class, 10)->create();

        $data = $states->sortBy('name')->values()
            ->map->only(['id', 'name'])
            ->all();

        $response = $this->json('GET', '/api/cities');

        $response->assertStatus(200)
            ->assertJson(compact('data'));
    }
}
