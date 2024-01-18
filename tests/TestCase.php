<?php

namespace Cove\MacroAttributes\Tests;

use Cove\MacroAttributes\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): iterable
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        tap($app['config'], function (Repository $config) {
            $config->set('macros.namespaces', ['Cove\MacroAttributes\Tests\Cases']);
        });
    }
}
