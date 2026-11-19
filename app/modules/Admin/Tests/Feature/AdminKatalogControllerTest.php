<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Identity\Models\User;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;
use Tests\TestCase;

class AdminKatalogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_equipment_catalog_renders_database_items(): void
    {
        $admin = User::query()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin@example.com',
            'password' => 'password',
            'peran' => 'admin',
            'email_verified_at' => now(),
        ]);
        $rentalUser = User::query()->create([
            'nama' => 'Pemilik Rental',
            'email' => 'rental@example.com',
            'password' => 'password',
            'peran' => 'rental',
            'email_verified_at' => now(),
        ]);
        $rental = TokoRental::query()->create([
            'user_id' => $rentalUser->id,
            'nama_toko' => 'Rental Database',
            'status' => 'active',
        ]);
        Peralatan::query()->create([
            'toko_rental_id' => $rental->id,
            'nama' => 'Tenda Database',
            'tarif_harian' => 75000,
            'jumlah_stok' => 4,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.moderasi-katalog', ['jenis' => 'alat']))
            ->assertOk()
            ->assertSee('Tenda Database')
            ->assertSee('Rental Database')
            ->assertSee('75.000');
    }
}
