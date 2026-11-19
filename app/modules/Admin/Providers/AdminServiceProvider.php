<?php

namespace Modules\Admin\Providers;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Modules\Guide\Models\Pemandu;
use Modules\Rental\Models\TokoRental;
use Modules\Shared\Providers\ModuleServiceProvider;

class AdminServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string
    {
        return 'Admin';
    }

    protected function viewNamespace(): string
    {
        return 'admin';
    }

    public function boot(): void
    {
        parent::boot();

        View::composer('admin::partials.sidebar', function (ViewContract $view): void {
            $totalPendingMitra = Pemandu::where('status', 'pending')->count()
                + TokoRental::where('status', 'pending')->count();

            $view->with('totalPendingMitra', $totalPendingMitra);
        });
    }
}
