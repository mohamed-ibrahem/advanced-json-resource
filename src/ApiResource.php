<?php

namespace AdvancedJsonResource;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Throwable;

abstract class ApiResource extends JsonResource
{
    use Concerns\DelegatesToResponse;
    use Concerns\HasSharedMethod;

    /**
     * The response method.
     *
     * @var string
     */
    public static $method = '';

    /**
     * {@inheritdoc}
     *
     * @param mixed $resource
     * @return AnonymousApiResourceCollection
     */
    public static function collection($resource): AnonymousApiResourceCollection
    {
        return tap(static::newCollection($resource), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                /** @phpstan-ignore-next-line */
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }


    /**
     * {@inheritdoc}
     *
     * @param mixed $resource
     * @return AnonymousApiResourceCollection
     */
    protected static function newCollection($resource): AnonymousApiResourceCollection
    {
        return new AnonymousApiResourceCollection(
            $resource,
            static::class,
            static::$method,
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param string $method
     * @param array<int, array<int, mixed>> $parameters
     * @return mixed
     *
     * @throws Throwable
     */
    public static function __callStatic($method, $parameters)
    {
        try {
            return parent::__callStatic($method, $parameters);
        } catch (Throwable $e) {
            $responseMethod = (string)Str::of($method)
                ->studly()
                ->prepend('to');

            if (method_exists(static::class, $responseMethod)) {
                return AnonymousApiResource::make(
                    static::class,
                    $responseMethod,
                    ...$parameters
                );
            }

            throw $e;
        }
    }
}
