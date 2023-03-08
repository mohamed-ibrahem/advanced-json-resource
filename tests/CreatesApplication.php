<?php

namespace AdvancedJsonResource\Tests;

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
}
