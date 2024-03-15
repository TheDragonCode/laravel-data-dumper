<?php

declare(strict_types=1);

namespace Tests\Fixtures\Database;

use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class Migration extends BaseMigration
{
    protected string $tableName;

    public function up(): void
    {
        $this->createTable();
        $this->fillTable();
    }

    protected function createTable(): void
    {
        Schema::create($this->tableName(), function (Blueprint $table) {
            $table->id();

            $table->string($this->column());

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    protected function fillTable(): void
    {
        circleProcess(fn (int $i) => $this->table()->insert([
            $this->column() => $this->value($i),
        ]));
    }

    protected function column(): string
    {
        return columnName($this->tableName);
    }

    protected function value(int $index): string
    {
        return valueName($this->tableName, $index);
    }

    protected function tableName(): string
    {
        return tableName($this->tableName);
    }

    protected function table(): Builder
    {
        return DB::table($this->tableName());
    }
}
