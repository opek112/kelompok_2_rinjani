<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Booking\Models\Pemesanan;
use Modules\Identity\Models\User;
use Modules\Payment\Models\LogPembayaran;
use Modules\Payment\Models\Pembayaran;
use Tests\TestCase;

class AdminAuditLogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_audit_page_renders_saved_payment_webhook_logs(): void
    {
        $admin = User::query()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin@example.com',
            'password' => 'password',
            'peran' => 'admin',
            'email_verified_at' => now(),
        ]);
        $pemesanan = Pemesanan::query()->create([
            'kode_pemesanan' => 'RJN-2026-0099',
            'nama_ketua' => 'Pelanggan Uji',
            'email_ketua' => 'pelanggan@example.com',
            'telepon_ketua' => '081234567890',
            'nik_ketua' => '5201021908950001',
            'tanggal_mulai' => today(),
            'tanggal_selesai' => today()->addDay(),
            'total_hari' => 2,
            'total_tagihan' => 500000,
            'status' => 'paid',
        ]);
        $pembayaran = Pembayaran::query()->create([
            'pemesanan_id' => $pemesanan->id,
            'referensi_pembayaran' => 'QRIS-RJN-2026-0099',
            'nominal' => 500000,
            'status_pembayaran' => 'settlement',
        ]);
        LogPembayaran::query()->create([
            'pembayaran_id' => $pembayaran->id,
            'payload_mentah' => '{"status":"settlement"}',
            'tanda_tangan_valid' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.log-audit'))
            ->assertOk()
            ->assertSee('RJN-2026-0099')
            ->assertSee('Settlement')
            ->assertSee('Valid');
    }
}
