<?php

namespace AdvancedJsonResource;

use AdvancedJsonResource\Concerns\DelegatesToResponse;
use AdvancedJsonResource\Concerns\HasSharedMethod;
use ArrayAccess;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class ApiResource extends JsonResource
{
    use HasSharedMethod, DelegatesToResponse;

    /**
     * Current method used to build the response.
     *
     * @var string
     */
    private static $method;

    /**
     * @param string $method
     * @param ...$parameters
     * @return JsonResource
     */
    public static function init(string $method, ...$parameters): JsonResource
    {
        static::$method = $method;

        $resource = collect(...$parameters);

        if (self::shouldCollected($resource)) {
            return static::collection($resource);
        }

        return static::make(...$parameters);
    }

    /**
     * Get current method used to build the response.
     *
     * @param string $method
     * @return string
     */
    public static function getResponseMethod(string $method): string
    {
        return (string)Str::of($method)->title()->prepend('to');
    }

    /**
     * Determine if the given resource should be collected into a collection resource.
     *
     * @param Collection $resource
     * @return bool
     */
    public static function shouldCollected(Collection $resource): bool
    {
        return is_array($resource->first()) || $resource->first() instanceof ArrayAccess;
    }
}
