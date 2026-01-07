# Database Data Dumper for Laravel

![the dragon code database data dumper](https://banners.beyondco.de/Database%20Data%20Dumper.png?theme=light&packageManager=composer+require&packageName=dragon-code%2Flaravel-data-dumper&pattern=topography&style=style_2&description=by+The+Dragon+Code&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

[![Stable Version][badge_stable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![Github Workflow Status][badge_build]][link_build]
[![License][badge_license]][link_license]

## Introduction

The [squashing migrations](https://laravel.com/docs/migrations#squashing-migrations) in Laravel does not export data
from tables?

There is a solution!

### How it works?

After installing and configuring the package, you simply run the console command `php artisan schema:dump` (with or
without flags - it's up to you), and the final SQL dump file will contain the data structure including the contents of
the tables you specified at the configuration stage.

This will allow you to painlessly execute the `php artisan schema:dump --prune` command, which will remove unnecessary
migration files.

## Requirements

- Laravel 10, 11, 12
- PHP 8.2 or higher
- Databases:
    - Sqlite 3
    - MySQL 5.7, 8, 9
    - PostgreSQL 12, 13, 14, 15, 16, 17

## Installation

To get the latest version of `Database Data Dumper`, simply require the project
using [Composer](https://getcomposer.org):

```Bash
composer require dragon-code/laravel-data-dumper
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "dragon-code/laravel-data-dumper": "^1.0"
    }
}
```

## Configuration

Since Laravel mechanism for publishing configuration files does not allow them to be merged on the fly,
a new array element must be added to the [`config/database.php`](config/settings.php) file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Schema Settings
    |--------------------------------------------------------------------------
    |
    | This block will contain the names of the tables for which it is
    | necessary to export data along with the table schema.
    |
    */

    'schema' => [
        'tables' => [
            // 'foo',
            // 'bar',
            // App\Models\Article::class,

            // 'qwerty1' => ['column_name_1', 'database/foo'],
            // 'qwerty2' => ['column_name_2', __DIR__ . '/../bar'],
        ],
    ],
];
```

After that, add to the array the names of the tables for which you want to export data.

That's it. Now you can run the [`php artisan schema:dump`](https://laravel.com/docs/migrations#squashing-migrations)
console command and enjoy the result.

> [!NOTE]
>
> If you need to delete files from a folder to which a table is related (for example, the `migrations` table),
> you can specify an array of two values in the parameter, where the first element should be the name of the column
> containing the file name, and the second element should be absolute or relative folder path.

> [!WARNING]
>
> Laravel 11.35.2 and below does not know how to report the presence of the `--prune` parameter when calling the
> `artisan schema:dump` console command, so specifying paths to folders will always delete files from them.
>
> Starting with Laravel version 11.36, files will be deleted only when calling the console command with the
> `--prune` parameter.


## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:          https://img.shields.io/github/actions/workflow/status/TheDragonCode/laravel-data-dumper/tests.yml?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/laravel-data-dumper.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/laravel-data-dumper.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/laravel-data-dumper?label=stable&style=flat-square

[link_build]:           https://github.com/TheDragonCode/laravel-data-dumper/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/laravel-data-dumper
