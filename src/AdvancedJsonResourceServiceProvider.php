<?php

namespace AdvancedJsonResource;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AdvancedJsonResourceServiceProvider extends ServiceProvider
{
    /**
     * List of response methods to register.
     *
     * @var array<int, string>
     */
    private $responseMethods = [
        'index', 'show', 'form',
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        foreach ($this->responseMethods as $method) {
            JsonResource::macro($method, static function (...$parameters) use($method) {
                return static::init($method, ...$parameters);
            });
        }
    }
}
