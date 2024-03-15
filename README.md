# Database Data Dumper for Laravel

![the dragon code database data dumper](https://preview.dragon-code.pro/the-dragon-code/database-data-dumper.svg?brand=laravel)

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![Github Workflow Status][badge_build]][link_build]
[![License][badge_license]][link_license]

## Introduction

Laravel's standard mechanism for [squashing migrations](https://laravel.com/docs/migrations#squashing-migrations)
is very good, but it has a huge drawback - it only exports the database schema and the contents of
a single table - `migrations`.

And this approach is quite acceptable on small projects where you need to quickly reduce the number of migration files
and there is no binding to the table contents.

But what if you have a large project with several people working on it, and you constantly run tests that must contain
some data from production? For example, statuses, lists and other important data. When do you have everything tied to
specific identifiers and enums?

This package will help you in this case! It "sees" when you call the console command `php artisan schema:dump` and
unloads the data from your selected tables into SQL file.

All you need to do is install the package and add the new setting to the `config/database.php` file and that's it.

Let's get down to business!

## Requirements

- Laravel 10, 11
- PHP 8.2 or higher
- (optional) Databases:
  - Sqlite: 3
  - MySQL 5.7, 8.0, 8.1, 8.2, 8.3
  - PostgreSQL 12, 13, 14, 15, 16

## Installation

To get the latest version of `DDD`, simply require the project using [Composer](https://getcomposer.org):

```Bash
composer require dragon-code/laravel-data-dumper --dev
```

Or manually update `require-dev` block of `composer.json` and run `composer update`.

```json
{
    "require-dev": {
        "dragon-code/laravel-data-dumper": "^3.0"
    }
}
```

## Configuration

Since Laravel's mechanism for publishing configuration files does not allow them to be merged on the fly,
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
        ],
    ],
];
```

After that, add to the array the names of the tables for which you want to export data.

That's it. Now run the `php artisan schema:dump` console command and enjoy the result.


## License

This package is licensed under the [MIT License](LICENSE).


[badge_build]:          https://img.shields.io/github/actions/workflow/status/TheDragonCode/laravel-data-dumper/phpunit.yml?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/laravel-data-dumper.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/laravel-data-dumper.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/laravel-data-dumper?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/TheDragonCode/laravel-data-dumper/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/laravel-data-dumper
