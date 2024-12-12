<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;

expect()->extend('toBeFilledTables', function () {
    foreach (names() as $name) {
        expect(
            DB::table(tableName($name))->count()
        )->toBe($name === 'qwerty1' ? 5 : 10);
    }

    return $this;
});
