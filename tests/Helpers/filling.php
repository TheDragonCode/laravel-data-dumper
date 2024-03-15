<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;

expect()->extend('toBeFilledTables', function () {
    foreach (names() as $name) {
        expect(
            DB::table(tableName($name))->count()
        )->toBe(10);
    }

    return $this;
});
