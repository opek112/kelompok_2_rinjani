<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Booking\Models\Pemesanan;
use Modules\Identity\Models\User;
use Tests\TestCase;

class AdminDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_renders_database_transaction_totals_and_monthly_data(): void
    {
        $admin = User::query()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin@example.com',
            'password' => 'password',
            'peran' => 'admin',
            'email_verified_at' => now(),
        ]);

        Pemesanan::query()->create($this->bookingAttributes('RJN-2026-0001', 'paid', 500000, 50000));
        Pemesanan::query()->create($this->bookingAttributes('RJN-2026-0002', 'pending', 120000, 0));

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Rp 500.000')
            ->assertSee('1 trx')
            ->assertSee('RJN-2026-0001')
            ->assertSee('2');
    }

    /**
     * @return array<string, mixed>
     */
    private function bookingAttributes(string $code, string $status, int $total, int $commission): array
    {
        return [
            'kode_pemesanan' => $code,
            'nama_ketua' => 'Pelanggan Uji',
            'email_ketua' => 'pelanggan@example.com',
            'telepon_ketua' => '081234567890',
            'nik_ketua' => '5201021908950001',
            'tanggal_mulai' => today(),
            'tanggal_selesai' => today()->addDay(),
            'total_hari' => 2,
            'total_tagihan' => $total,
            'nominal_komisi' => $commission,
            'status' => $status,
        ];
    }
}
