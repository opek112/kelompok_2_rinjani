<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Admin\Models\PengaturanPlatform;
use Modules\Identity\Models\User;
use Tests\TestCase;

class AdminConfigurationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_page_prefers_database_values_when_available(): void
    {
        $admin = User::query()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin@example.com',
            'password' => 'password',
            'peran' => 'admin',
            'email_verified_at' => now(),
        ]);
        PengaturanPlatform::query()->create([
            'kunci' => 'nama_platform',
            'nilai' => 'Nama Platform dari Database',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.pengaturan'))
            ->assertOk()
            ->assertSee('Nama Platform dari Database');
    }

    public function test_integration_page_does_not_render_payment_secrets(): void
    {
        $admin = User::query()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin@example.com',
            'password' => 'password',
            'peran' => 'admin',
            'email_verified_at' => now(),
        ]);
        config([
            'midtrans.server_key' => 'SB-Mid-server-private-value',
            'midtrans.client_key' => 'SB-Mid-client-private-value',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.integrasi'))
            ->assertOk()
            ->assertSee('Terkonfigurasi')
            ->assertDontSee('SB-Mid-server-private-value')
            ->assertDontSee('SB-Mid-client-private-value');
    }
}
