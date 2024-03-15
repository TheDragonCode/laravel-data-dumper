<?php

declare(strict_types=1);

namespace DragonCode\LaravelDataDumper;

use DragonCode\LaravelDataDumper\Concerns\About;
use DragonCode\LaravelDataDumper\Listeners\DumpListener;
use Illuminate\Database\Events\SchemaDumped;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    use About;

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerAbout();
            $this->bootListener();
        }
    }

    public function register(): void
    {
        $this->registerConfig();
    }

    protected function bootListener(): void
    {
        Event::listen(SchemaDumped::class, DumpListener::class);
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/settings.php', 'database');
    }
}
