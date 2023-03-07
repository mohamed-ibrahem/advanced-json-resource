<?php

namespace AdvancedJsonResource\Tests;

use AdvancedJsonResource\Tests\Fixtures\Models\User;
use AdvancedJsonResource\Tests\Fixtures\Resources\ArrayResource;
use AdvancedJsonResource\Tests\Fixtures\Resources\UserResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SingleResourceTest extends TestCase
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

        User::factory()->create();
    }

    /** @test */
    public function show_method_with_single_array(): void
    {
        $resource = ArrayResource::show([
            'id' => 1,
            'name' => 'User name',
            'email' => 'user@example.com',
        ]);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('name', $data);
        $this->assertEquals([
            'id' => 1,
            'email' => 'user@example.com',
        ], $data);
    }

    /** @test */
    public function form_method_with_single_array(): void
    {
        $resource = ArrayResource::form([
            'id' => 1,
            'name' => 'User name',
            'email' => 'user@example.com',
        ]);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('name', $data);
        $this->assertArrayNotHasKey('email', $data);
        $this->assertEquals([
            'id' => 1,
            'can_update' => true,
        ], $data);
    }

    /** @test */
    public function custom_method_with_single_array(): void
    {
        $resource = ArrayResource::custom([
            'id' => 1,
            'name' => 'User name',
            'email' => 'user@example.com',
        ]);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('name', $data);
        $this->assertArrayNotHasKey('email', $data);
        $this->assertEquals([
            'id' => 1,
            'custom' => 'custom',
        ], $data);
    }

    /** @test */
    public function show_method_with_single_model(): void
    {
        $user = User::first();
        $resource = UserResource::show($user);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('name', $data);
        $this->assertEquals([
            'id' => $user->id,
            'email' => $user->email,
        ], $data);
    }

    /** @test */
    public function form_method_with_single_model(): void
    {
        $user= User::first();
        $resource = UserResource::form($user);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('name', $data);
        $this->assertArrayNotHasKey('email', $data);
        $this->assertEquals([
            'id' => $user->id,
            'can_update' => true,
        ], $data);
    }

    /** @test */
    public function custom_method_with_single_model(): void
    {
        $user = User::first();
        $resource = UserResource::custom($user);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('name', $data);
        $this->assertArrayNotHasKey('email', $data);
        $this->assertEquals([
            'id' => $user->id,
            'custom' => 'custom',
        ], $data);
    }
}
