<?php

namespace Tests\Feature;

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
        $states = factory(State::class, 10)->create();

        $data = $states->sortBy('name')->values()
            ->map->only(['id', 'code' , 'name'])
            ->all();

        $response = $this->json('GET', '/api/states');

        $response->assertStatus(200)
            ->assertJson(compact('data'));
    }
}
