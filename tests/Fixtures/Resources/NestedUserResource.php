<?php

namespace AdvancedJsonResource\Tests\Fixtures\Resources;

use AdvancedJsonResource\ApiResource;
use AdvancedJsonResource\Tests\Fixtures\Models\User;
use Illuminate\Http\Request;

/**
 * @mixin User
 */
class NestedUserResource extends ApiResource
{
    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toShow(Request $request): array
    {
        return [
            'email' => $this->email,
            'nested' => UserResource::index($this->resource),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function shared(Request $request): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
