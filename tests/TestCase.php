<?php

namespace Tests;

use App\Charter;
use App\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        config(['database.connections.landlord' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],

            'database.connections.team' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],
        ]);

        Charter::manageDatabasesUsing(FakeDatabaseManager::class);

        $this->artisan('migrate --database=landlord --path=database/migrations/landlord');
        $this->artisan('migrate:fresh --database=team');

        $this->app[Kernel::class]->setArtisan(null);
    }
}
