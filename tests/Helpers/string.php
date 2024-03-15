<?php

declare(strict_types=1);

use Illuminate\Support\Str;

use function PHPUnit\Framework\assertSame;

expect()->extend('toBeWordsCount', function (string $word, int $count) {
    assertSame($count, Str::substrCount($this->value, $word));

    return $this;
});
