<?php

namespace Tests\Feature;

use App\ContractType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndex()
    {
        $countries = factory(ContractType::class, 10)->create();

        $data = $countries->sortBy('name')->values()
            ->map->only(['id', 'name' , 'document_name', 'document_format'])
            ->all();

        $response = $this->json('GET', '/api/contracts/types');

        $response->assertStatus(200)
            ->assertJson(compact('data'));
    }
}
