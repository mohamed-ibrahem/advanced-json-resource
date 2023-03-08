<?php

namespace AdvancedJsonResource;

use Illuminate\Http\Resources\Json\JsonResource;

class AnonymousApiResource
{
    /**
     * The responsible ApiResource object.
     *
     * @var class-string<ApiResource>
     */
    private $responsable;

    /**
     * The response method.
     *
     * @var string
     */
    private $method;

    /**
     * The resource's collection.
     *
     * @var array<int|string, mixed>|null
     */
    private $resources;

    /**
     * @param class-string<ApiResource> $responseable
     * @param string $method
     * @param array<int|string, mixed>|null $resources
     */
    public function __construct(string $responseable, string $method, $resources = null)
    {
        $this->responsable = $responseable;
        $this->method = $method;
        $this->resources = $resources;
    }

    /**
     * Create a new Api Response class.
     *
     * @param mixed ...$parameters
     * @return JsonResource
     */
    public static function make(...$parameters): JsonResource
    {
        /** @phpstan-ignore-next-line */
        return (new static(...$parameters))->build();
    }

    /**
     * Build up a resource response.
     *
     * @return JsonResource
     */
    protected function build(): JsonResource
    {
        $response = $this->responsable;

        $response::$method = $this->method;

        if ($this->shouldCollect()) {
            return $response::collection($this->resources);
        }

        return $response::make($this->resources);
    }

    /**
     * Determine if the given resource should be collected.
     *
     * @return bool
     */
    protected function shouldCollect(): bool
    {
        return filled(data_get($this->resources, 0));
    }
}
