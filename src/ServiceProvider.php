<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper;

use DragonCode\LaravelDataDumper\Concerns\About;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    use About;

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerAbout();
        }
    }

    public function register(): void
    {
    }
}
