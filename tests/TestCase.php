<?php

namespace Tests;

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

            'database.connections.tenant' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],
        ]);



        $this->artisan('migrate --database=landlord --path=database/migrations/landlord');
        // $this->artisan('migrate:fresh --database=tenant');

        $this->app[Kernel::class]->setArtisan(null);
    }
}
