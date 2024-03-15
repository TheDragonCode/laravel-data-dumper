<?php

namespace Tests;

use DragonCode\LaravelDataDumper\ServiceProvider;
use Illuminate\Config\Repository;
use Orchestra\Testbench\TestCase as BaseTestCase;
use PDO;
use Tests\Fixtures\Providers\TestServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        /** @var Repository $config */
        $config = $app['config'];

        $config->set('database.schema.tables', [
            tableName('foo'),
            tableName('bar'),
        ]);

        $config->set('database.default', env('DB_CONNECTION', 'sqlite'));

        $config->set('database.connections', [
            'sqlite' => [
                'driver'                  => 'sqlite',
                'database'                => databasePath(),
                'prefix'                  => '',
                'foreign_key_constraints' => true,
            ],

            'mysql' => [
                'driver'         => 'mysql',
                'host'           => env('DB_HOST', '127.0.0.1'),
                'port'           => env('DB_PORT', '3306'),
                'database'       => env('DB_DATABASE', 'laravel'),
                'username'       => env('DB_USERNAME', 'root'),
                'password'       => env('DB_PASSWORD', ''),
                'unix_socket'    => env('DB_SOCKET', ''),
                'charset'        => env('DB_CHARSET', 'utf8mb4'),
                'collation'      => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
                'prefix'         => '',
                'prefix_indexes' => true,
                'strict'         => true,
                'engine'         => null,
                'options'        => extension_loaded('pdo_mysql') ? array_filter([
                    PDO::MYSQL_ATTR_SSL_CA => null,
                ]) : [],
            ],

            'pgsql' => [
                'driver'         => 'pgsql',
                'host'           => env('DB_HOST', '127.0.0.1'),
                'port'           => env('DB_PORT', '5432'),
                'database'       => env('DB_DATABASE', 'laravel'),
                'username'       => env('DB_USERNAME', 'root'),
                'password'       => env('DB_PASSWORD', ''),
                'charset'        => env('DB_CHARSET', 'utf8'),
                'prefix'         => '',
                'prefix_indexes' => true,
                'search_path'    => 'public',
                'sslmode'        => 'prefer',
            ],
        ]);
    }
}
