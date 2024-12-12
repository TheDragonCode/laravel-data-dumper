<?php

declare(strict_types=1);

use Tests\Fixtures\Database\Migration;

return new class extends Migration {
    protected string $tableName = 'qwerty2';

    protected function fillTable(): void
    {
        circleProcess(fn (int $i) => $this->table()->insert([
            $this->column() => sprintf('sub/qwerty2File%s.stub', $i),
        ]));
    }
};
