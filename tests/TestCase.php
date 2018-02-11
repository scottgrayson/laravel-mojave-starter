<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected function createAdminRole()
    {
        \Artisan::call('db:seed', [
            '--class' => 'RolePermissionSeeder'
        ]);
    }

    protected function feedback($response)
    {
        if (get_class($response->baseResponse) === 'Illuminate\Http\RedirectResponse') {
            dump($response->baseResponse->getSession());
        } else {
            $this->dump($response);
        }
    }

    protected function dump($response, $count = 200)
    {
        dump(substr($response->content(), 0, $count));
    }
}
