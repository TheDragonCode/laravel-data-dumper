<?php

declare(strict_types=1);

function circleProcess(Closure $callback): void
{
    for ($i = 0; $i < 10; $i++) {
        $callback($i);
    }
}
