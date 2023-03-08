<?php

namespace AdvancedJsonResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AnonymousApiResourceCollection extends AnonymousResourceCollection
{
    /**
     * The response method.
     *
     * @var string
     */
    private $method;

    /**
     * {@inheritdoc}
     *
     * @param  mixed  $resource
     * @param  string  $collects
     * @return void
     */
    public function __construct($resource, $collects, string $method)
    {
        $this->method = $method;

        parent::__construct($resource, $collects);
    }

    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function($resource) use($request) {
            $resource::$method = $this->method;

            return $resource->toArray($request);
        })->all();
    }
}
