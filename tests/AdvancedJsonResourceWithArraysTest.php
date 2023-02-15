<?php

namespace AdvancedJsonResource\Tests;

use AdvancedJsonResource\Tests\Fixtures\Resources\ArrayResource;

class AdvancedJsonResourceWithArraysTest extends TestCase
{
    /** @test */
    public function it_can_build_json_response_form_index_method(): void
    {
        $resource = ArrayResource::index([
            'id' => 1,
            'name' => 'User name',
            'email' => 'user@example.com',
        ]);

        $response = $resource->response()->getData();
        $data = (array) $response->data;

        $this->assertCount(2, $data);
        $this->assertArrayNotHasKey('email', $data);
        $this->assertEquals([
            'id' => 1,
            'name' => 'User name',
        ], $data);
    }

    /** @test */
    public function it_can_build_json_response_form_show_method(): void
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
    public function it_can_build_json_response_form_form_method(): void
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
    public function it_can_build_json_response_form_custom_method(): void
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
    public function it_can_build_json_response_form_collection(): void
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
}
