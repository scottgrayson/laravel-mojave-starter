<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->deleteTestFiles();

        return $app;
    }

    /**
     * phpunit.xml uses local filesystem
     * clear the files when tests run
     */
    public function deleteTestFiles()
    {
        $path = storage_path('testing');
        $output = shell_exec("rm -rf $path");
    }
}
