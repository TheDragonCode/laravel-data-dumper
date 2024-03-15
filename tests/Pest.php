<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)
    ->beforeAll(function () {
        if (!file_exists($database = databasePath())) {
            file_put_contents($database, '');
        }
    })
    ->compact()
    ->in('Unit');
