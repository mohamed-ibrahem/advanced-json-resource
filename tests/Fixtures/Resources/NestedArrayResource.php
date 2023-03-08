<?php

namespace AdvancedJsonResource\Tests\Fixtures\Resources;

use AdvancedJsonResource\ApiResource;
use Illuminate\Http\Request;

class NestedArrayResource extends ApiResource
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
            'email' => $this['email'],
            'nested' => ArrayResource::index($this->resource),
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
            'id' => $this['id'],
        ];
    }
}
