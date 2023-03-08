<?php

namespace AdvancedJsonResource\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

trait DelegatesToResponse
{
    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return mixed[]|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $method = static::$method;

        if (method_exists(static::class, $method)) {
            /** @var array<int|string, mixed> $response */
            $response = $this->$method($request);

            return array_merge($this->shared($request), $response);
        }

        return parent::toArray($request);
    }

    /**
     * Transform the resource into an array for index response.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toIndex(Request $request): array
    {
        return [];
    }

    /**
     * Transform the resource into an array for show response.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toShow(Request $request): array
    {
        return [];
    }

    /**
     * Transform the resource into an array for form response.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toForm(Request $request): array
    {
        return [];
    }
}
