<?php

namespace Modules\Shared\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

abstract class ModuleServiceProvider extends ServiceProvider
{
    abstract protected function moduleName(): string;
    abstract protected function viewNamespace(): string;

    protected function modulePath(string $path = ''): string
    {
        return base_path('modules/'.->moduleName().($path ? '/'.$path : ''));
    }

    public function boot(): void
    {
        $this->loadViewsFrom($this->modulePath('Resources/views'), $this->viewNamespace());

        if (is_dir($this->modulePath('Database/Migrations'))) {
            $this->loadMigrationsFrom($this->modulePath('Database/Migrations'));
        }

        if (file_exists($this->modulePath('Routes/web.php'))) {
            Route::middleware('web')->group($this->modulePath('Routes/web.php'));
        }
    }
}
