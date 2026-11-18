<?php

namespace Modules\Guide\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Modules\Booking\Models\Pemesanan;
use Modules\Guide\Models\Pemandu;
use Modules\Guide\Policies\PemesananPolicy;
use Modules\Shared\Providers\ModuleServiceProvider;

class GuideServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Guide'; }
    protected function viewNamespace(): string { return 'Guide'; }

    public function boot(): void
    {
        parent::boot();

        Gate::policy(Pemesanan::class, PemesananPolicy::class);

        View::composer('layouts.guide', function ($view) {
            $user = Auth::user();

            $pemandu = $user !== null && $user->peran === 'guide'
                ? Pemandu::query()->where('user_id', $user->id)->first()
                : null;

            $perluKonfirmasi = $pemandu !== null
                ? Pemesanan::query()
                    ->where('pemandu_id', $pemandu->id)
                    ->where('status', 'paid')
                    ->where('kehadiran_pemandu_dikonfirmasi', false)
                    ->whereDate('tanggal_selesai', '>=', today()->toDateString())
                    ->count()
                : 0;

            $view->with([
                'navUser' => $user,
                'navPemandu' => $pemandu,
                'navPerluKonfirmasi' => $perluKonfirmasi,
            ]);
        });
    }
}
