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
    public function testStore()
    {
        $property = factory(Property::class)->make();

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(201)
            ->assertJson(compact('data'));
    }

    /**
     * @return void
     */
    public function testStoreWithoutNumber()
    {
        $property = factory(Property::class)->make(['number' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(201)
            ->assertJson(compact('data'));
    }

    /**
     * @return void
     */
    public function testStoreWithoutComplement()
    {
        $property = factory(Property::class)->make(['complement' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $data = Arr::except($property->toArray(), ['city_id']);

        $response->assertStatus(201)
            ->assertJson(compact('data'));
    }

    /**
     * @return void
     */
    public function testValidateEmail()
    {
        $property = factory(Property::class)->make(['email' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email' => 'The email field is required.'])
        ;
    }

    /**
     * @return void
     */
    public function testValidateStreet()
    {
        $property = factory(Property::class)->make(['street' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['street' => 'The street field is required.'])
        ;
    }

    /**
     * @return void
     */
    public function testValidateDistrict()
    {
        $property = factory(Property::class)->make(['district' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['district' => 'The district field is required.'])
        ;
    }

    /**
     * @return void
     */
    public function testValidateCity()
    {
        $property = factory(Property::class)->make(['city_id' => '']);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['city_id' => 'The city id field is required.'])
        ;
    }

    /**
     * @return void
     */
    public function testValidateInvalidCity()
    {
        $property = factory(Property::class)->make(['city_id' => 10]);

        $response = $this->json('POST', '/api/properties', $property->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['city_id' => 'The selected city id is invalid.'])
        ;
    }
}
