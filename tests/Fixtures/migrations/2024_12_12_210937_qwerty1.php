<?php

declare(strict_types=1);

use Tests\Fixtures\Database\Migration;

return new class extends Migration {
    protected string $tableName = 'qwerty1';

    protected function fillTable(): void
    {
        circleProcess(function (int $i) {
            if ($i % 2 === 0) {
                return;
            }

            $this->table()->insert([
                $this->column() => sprintf('qwerty1File%s.stub', $i),
            ]);
        });
    }
};
