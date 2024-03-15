<?php

declare(strict_types=1);

function names(): array
{
    return ['foo', 'bar', 'baz'];
}

function tableName(string $name): string
{
    return 'table_' . $name;
}

function columnName(string $table): string
{
    return 'title_' . $table;
}

function valueName(string $table, int $index): string
{
    return $table . '_value_' . $index;
}
