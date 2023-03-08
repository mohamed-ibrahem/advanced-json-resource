<?php

namespace AdvancedJsonResource\Tests;

use AdvancedJsonResource\Tests\Fixtures\Models\User;
use AdvancedJsonResource\Tests\Fixtures\Resources\ArrayResource;
use AdvancedJsonResource\Tests\Fixtures\Resources\NestedArrayResource;
use AdvancedJsonResource\Tests\Fixtures\Resources\NestedUserResource;
use AdvancedJsonResource\Tests\Fixtures\Resources\UserResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NestedResourcesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        User::factory(5)->create();
    }

    /** @test */
    public function show_method_with_single_nested_array(): void
    {
        $resource = NestedArrayResource::show([
            'id' => 1,
            'name' => 'User name',
            'email' => 'user@example.com',
        ]);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(3, $data);
        $this->assertArrayNotHasKey('name', $data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('nested', $data);
        $this->assertArrayHasKey('id', (array) $data['nested']);
        $this->assertArrayHasKey('name', (array) $data['nested']);
    }

    /** @test */
    public function show_method_with_single_nested_model(): void
    {
        $user = User::first();
        $resource = NestedUserResource::show($user);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(3, $data);
        $this->assertArrayNotHasKey('name', $data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('nested', $data);
        $this->assertArrayHasKey('id', (array) $data['nested']);
        $this->assertArrayHasKey('name', (array) $data['nested']);
    }

    /** @test */
    public function show_method_with_collection_nested_array(): void
    {
        $resource = NestedArrayResource::show([
            [
                'id' => 1,
                'name' => 'User name',
                'email' => 'user@example.com',
            ],
            [
                'id' => 2,
                'name' => 'User name',
                'email' => 'user@example.com',
            ],

        ]);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);

        foreach ($data as $record) {
            $item = (array) $record;

            $this->assertArrayNotHasKey('name', $item);
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('email', $item);
            $this->assertArrayHasKey('nested', $item);
            $this->assertArrayHasKey('id', (array) $item['nested']);
            $this->assertArrayHasKey('name', (array) $item['nested']);
        }
    }


    /** @test */
    public function show_method_with_collection_nested_model(): void
    {
        $user = User::get();
        $resource = NestedUserResource::show($user);

        $response = $resource->response()->getData();
        $data = (array) $response->data;


        $this->assertCount(5, $data);

        foreach ($data as $record) {
            $item = (array) $record;

            $this->assertArrayNotHasKey('name', $item);
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('email', $item);
            $this->assertArrayHasKey('nested', $item);
            $this->assertArrayHasKey('id', (array) $item['nested']);
            $this->assertArrayHasKey('name', (array) $item['nested']);
        }
    }
}
