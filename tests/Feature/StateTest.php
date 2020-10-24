<?php

namespace Tests\Feature;

use App\Country;
use App\State;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndex()
    {
        $country = factory(Country::class)->create();

        $states = factory(State::class, 10)->create(['country_id' => $country->id]);

        $data = $states->sortBy('name')->values()
            ->map->only(['id', 'code' , 'name'])
            ->all();

        $response = $this->json('GET', '/api/states?country_id='.$country->id);

        $response->assertStatus(200)
            ->assertJson(compact('data'));
    }

    /**
     * @return void
     */
    public function testIndexFailWithoutCountry()
    {
        factory(Country::class, 10)->create();

        $data = [];

        $response = $this->json('GET', '/api/states');

        $response->assertStatus(200)
            ->assertExactJson(compact('data'));
    }
}
