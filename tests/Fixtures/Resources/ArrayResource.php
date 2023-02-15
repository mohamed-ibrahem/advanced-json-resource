<?php

namespace AdvancedJsonResource\Tests\Fixtures\Resources;

use AdvancedJsonResource\ApiResource;
use Illuminate\Http\Request;

class ArrayResource extends ApiResource
{
    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toIndex(Request $request): array
    {
        return [
            'name' => $this['name'],
        ];
    }

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
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toForm(Request $request): array
    {
        return [
            'can_update' => true,
        ];
    }

    /**
     * This is a custom response method.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toCustom(Request $request): array
    {
        return [
            'custom' => 'custom',
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
