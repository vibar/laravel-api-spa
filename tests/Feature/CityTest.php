<?php

namespace Tests\Feature;

use App\City;
use App\State;
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
        $state = factory(State::class)->create();

        $cities = factory(City::class, 10)->create(['state_id' => $state->id]);

        $data = $cities->sortBy('name')->values()
            ->map->only(['id', 'name'])
            ->all();

        $response = $this->json('GET', '/api/cities?state_id='.$state->id);

        $response->assertStatus(200)
            ->assertJson(compact('data'));
    }

    /**
     * @return void
     */
    public function testIndexFailWithoutState()
    {
        factory(State::class, 10)->create();

        $data = [];

        $response = $this->json('GET', '/api/cities');

        $response->assertStatus(200)
            ->assertExactJson(compact('data'));
    }
}
