<?php

namespace AdvancedJsonResource\Concerns;

use BadMethodCallException;
use Illuminate\Http\Request;

trait DelegatesToResponse
{
    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $method = static::getResponseMethod(static::$method);

        if (method_exists(static::class, $method)) {
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

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        try {
            return parent::__callStatic($method, $parameters);
        } catch (BadMethodCallException $e) {
            $term = static::getResponseMethod($method);

            if (method_exists(static::class, $term)) {
                return static::init($method, ...$parameters);
            }

            throw $e;
        }
    }
}
