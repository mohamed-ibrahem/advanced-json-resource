<?php

namespace AdvancedJsonResource\Tests;

use AdvancedJsonResource\Tests\Fixtures\Models\User;
use AdvancedJsonResource\Tests\Fixtures\Resources\ArrayResource;
use AdvancedJsonResource\Tests\Fixtures\Resources\UserResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MultipleResourcesTest extends TestCase
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
    public function index_method_with_multiple_arrays(): void
    {
        $resource = ArrayResource::index([
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

        $record = (array) $data[0];

        $this->assertArrayNotHasKey('email', $record);
        $this->assertEquals([
            'id' => 1,
            'name' => 'User name',
        ], $record);
    }

    /** @test */
    public function index_method_with_multiple_models(): void
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
