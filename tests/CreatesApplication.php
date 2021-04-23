<?php

declare(strict_types=1);

namespace Tests;

use Exception;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return Application
     * @throws Exception
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->validateDatabase();

        return $app;
    }

    /**
     * @throws Exception
     */
    private function validateDatabase(): void
    {
        if (DB::getDefaultConnection() !== 'library_testing') {
            throw new Exception('Wrong testing database');
        }
    }

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }
}
