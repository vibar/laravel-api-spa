<?php

namespace Tests\Feature;

use App\Property;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndex()
    {
        $properties = factory(Property::class, 10)->create();

        $data = $properties->sortBy('email')->values()
            ->map->only(['id', 'email' , 'street', 'number', 'complement', 'district'])
            ->all();

        $response = $this->json('GET', '/api/properties');

        $response->assertStatus(200)
            ->assertJson(compact('data'));
    }

    /**
     * @return void
     */
    public function testStoreSuccess()
    {
        $property = factory(Property::class)->make();

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(201)
            ->assertJson(compact('data'));

        $this->assertDatabaseHas($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreSuccessWithoutNumber()
    {
        $property = factory(Property::class)->make(['number' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);
        $data['number'] = null;

        $response->assertStatus(201)
            ->assertJson(compact('data'));

        $this->assertDatabaseHas($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreSuccessWithoutComplement()
    {
        $property = factory(Property::class)->make(['complement' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);
        $data['complement'] = null;

        $response->assertStatus(201)
            ->assertJson(compact('data'));

        $this->assertDatabaseHas($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutEmail()
    {
        $property = factory(Property::class)->make(['email' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email' => 'The email field is required.']);

        $this->assertDatabaseMissing($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutStreet()
    {
        $property = factory(Property::class)->make(['street' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['street' => 'The street field is required.']);

        $this->assertDatabaseMissing($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutDistrict()
    {
        $property = factory(Property::class)->make(['district' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['district' => 'The district field is required.']);

        $this->assertDatabaseMissing($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithoutCity()
    {
        $property = factory(Property::class)->make(['city_id' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['city_id' => 'The city id field is required.']);

        $this->assertDatabaseMissing($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testStoreFailWithInvalidCity()
    {
        $property = factory(Property::class)->make(['city_id' => 10]);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['city_id' => 'The selected city id is invalid.']);

        $this->assertDatabaseMissing($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testDestroySuccess()
    {
        $property = factory(Property::class)->create();

        $response = $this->json('DELETE', '/api/properties/'.$property->getRouteKey());

        $data = Arr::except($property->toArray(), ['city_id', 'created_at', 'updated_at']);

        $response->assertStatus(200)
            ->assertJson(compact('data'));

        $this->assertSoftDeleted($property->getTable(), $data);
    }

    /**
     * @return void
     */
    public function testDestroyFailNotFound()
    {
        $property = factory(Property::class)->create();

        $response = $this->json('DELETE', '/api/properties/100');

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(404);

        $this->assertDatabaseHas($property->getTable(), $data);
    }
}
