<?php

namespace Tests\Feature;

use App\Country;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndex()
    {
        $countries = factory(Country::class, 10)->create();

        $data = $countries->sortBy('name')->values()
            ->map->only(['id', 'code' , 'name'])
            ->all();

        $response = $this->json('GET', '/api/countries');

        $response->assertStatus(200)
            ->assertJson(compact('data'));
    }
}
