<?php

namespace Tests\Feature;

use App\Contract;
use App\Property;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContractTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testStoreSuccess()
    {
        $contract = factory(Contract::class)->make();

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(201)
            ->assertJson(compact('data'));

        $this->assertDatabaseHas($contract->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutName()
    {
        $contract = factory(Contract::class)->make(['name' => '']);

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.']);

        $this->assertDatabaseMissing($contract->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutDocument()
    {
        $contract = factory(Contract::class)->make(['document' => '']);

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['document' => 'The document field is required.']);

        $this->assertDatabaseMissing($contract->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutEmail()
    {
        $contract = factory(Contract::class)->make(['email' => '']);

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email' => 'The email field is required.']);

        $this->assertDatabaseMissing($contract->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutType()
    {
        $contract = factory(Contract::class)->make(['type_id' => '']);

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['type_id' => 'The type id field is required.']);

        $this->assertDatabaseMissing($contract->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutProperty()
    {
        $contract = factory(Contract::class)->make(['property_id' => '']);

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['property_id' => 'The property id field is required.']);

        $this->assertDatabaseMissing($contract->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithInvalidType()
    {
        $contract = factory(Contract::class)->make(['type_id' => 10]);

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['type_id' => 'The selected type id is invalid.']);

        $this->assertDatabaseMissing($contract->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithInvalidProperty()
    {
        $contract = factory(Contract::class)->make(['property_id' => 10]);

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['property_id' => 'The selected property id is invalid.']);

        $this->assertDatabaseMissing($contract->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailPropertyAlreadyHasContract()
    {
        $property = factory(Property::class)->create();

        factory(Contract::class)->create(['property_id' => $property->id]);

        $contract = factory(Contract::class)->make(['property_id' => $property->id]);

        $response = $this->json('POST', '/api/contracts', $contract->toArray());

        $data = Arr::except($contract->toArray(), ['property_id', 'type_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['property_id' => 'The selected property id already has a contract.']);

        $this->assertDatabaseMissing($contract->getTable(), $data);
    }
}
