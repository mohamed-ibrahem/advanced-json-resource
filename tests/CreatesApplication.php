<?php

namespace AdvancedJsonResource\Tests;

use AdvancedJsonResource\AdvancedJsonResourceServiceProvider;

trait CreatesApplication
{
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Fixtures/migrations');
    }

    /**
     * {@inheritdoc}
     *
     * @param $app
     * @return array<int, string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            AdvancedJsonResourceServiceProvider::class,
        ];
    }
}
