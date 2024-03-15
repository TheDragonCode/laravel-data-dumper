<?php

declare(strict_types=1);

use Tests\Fixtures\Database\Migration;

return new class extends Migration {
    protected string $tableName = 'baz';
};
