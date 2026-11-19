<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Guide\Models\Pemandu;
use Modules\Identity\Models\User;
use Tests\TestCase;

class AdminActivityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_notifications_show_pending_partner_data_from_the_database(): void
    {
        $admin = User::query()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin@example.com',
            'password' => 'password',
            'peran' => 'admin',
            'email_verified_at' => now(),
        ]);
        $guideUser = User::query()->create([
            'nama' => 'Pemandu Database',
            'email' => 'pemandu@example.com',
            'password' => 'password',
            'peran' => 'guide',
            'email_verified_at' => now(),
        ]);
        Pemandu::query()->create([
            'user_id' => $guideUser->id,
            'tarif_harian' => 450000,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.notifikasi'))
            ->assertOk()
            ->assertSee('Pendaftaran pemandu baru')
            ->assertSee('Pemandu Database')
            ->assertDontSee('Joko Wijaya');
    }
}
