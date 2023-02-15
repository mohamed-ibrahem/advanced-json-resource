<?php

namespace AdvancedJsonResource\Tests;

use AdvancedJsonResource\Tests\Fixtures\Models\User;
use AdvancedJsonResource\Tests\Fixtures\Resources\UserResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdvancedJsonResourceWithCollectionsTest extends TestCase
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

        User::factory(10)->create();
    }

    /** @test */
    public function it_can_build_json_response_form_index_method(): void
    {
        $user = User::first();

        $resource = UserResource::index($user);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('email', $data);
        $this->assertEquals([
            'id' => $user->id,
            'name' => $user->name,
        ], $data);
    }

    /** @test */
    public function it_can_build_json_response_form_show_method(): void
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
    public function it_can_build_json_response_form_form_method(): void
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
    public function it_can_build_json_response_form_custom_method(): void
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

    /** @test */
    public function it_can_build_json_response_form_collection(): void
    {
        $users = User::take(5)->get();
        $resource = UserResource::index($users);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(5, $data);

        $record = (array) $data[0];

        $this->assertArrayNotHasKey('email', $record);
        $this->assertEquals([
            'id' => $users->first()->id,
            'name' => $users->first()->name,
        ], $record);
    }
}
