<?php

namespace Tests\Feature;

use Database\Seeders\RentalCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Booking\Models\Pemesanan;
use Modules\Payment\Models\Pembayaran;
use Modules\Rental\Models\Peralatan;
use Tests\TestCase;

class RentalFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RentalCatalogSeeder::class);
    }

    public function test_catalog_and_detail_pages_are_accessible(): void
    {
        $alat = Peralatan::query()->firstOrFail();

        $this->get(route('rental'))
            ->assertOk()
            ->assertSee('Sewa Alat Outdoor')
            ->assertSee($alat->nama);

        $this->get(route('rental.detail', $alat))
            ->assertOk()
            ->assertSee($alat->nama)
            ->assertSee('Tambah ke Keranjang');
    }

    public function test_guest_can_complete_checkout_payment_and_receive_voucher(): void
    {
        $alat = Peralatan::query()->firstOrFail();
        $mulai = now()->addDay()->toDateString();
        $selesai = now()->addDays(3)->toDateString();

        $this->post(route('rental.cart.add', $alat), [
            'jumlah' => 2,
            'tanggal_mulai' => $mulai,
            'tanggal_selesai' => $selesai,
            'aksi' => 'keranjang',
        ])->assertRedirect(route('rental.cart'));

        $this->get(route('rental.cart'))->assertOk()->assertSee($alat->nama);

        $this->get(route('rental.checkout'))->assertOk();

        $this->post(route('rental.checkout.store'), [
            'nama_ketua' => 'Andi Pratama',
            'telepon_ketua' => '081234567890',
            'email_ketua' => 'andi@example.com',
            'nik_ketua' => '5201021908950001',
            'setuju' => '1',
        ])->assertSessionHasNoErrors();

        $pemesanan = Pemesanan::query()->latest('id')->firstOrFail();

        $this->assertSame('RJN-'.now()->format('Y').'-0001', $pemesanan->kode_pemesanan);
        $this->assertSame('pending', $pemesanan->status);
        $this->assertSame(275000.0, (float) $pemesanan->total_tagihan);
        $this->assertSame(1, $pemesanan->items()->count());
        $this->assertSame(2, (int) $pemesanan->items()->first()->jumlah);
        $this->assertSame(3, (int) $pemesanan->total_hari);

        $this->get(route('rental.payment', $pemesanan->kode_pemesanan))
            ->assertOk()
            ->assertSee('Menunggu Pembayaran');

        $this->get(route('rental.payment', ['kode' => $pemesanan->kode_pemesanan, 'demo' => 'critical']))
            ->assertOk()
            ->assertSee('Segera Kedaluwarsa');

        $this->post(route('rental.payment.confirm', $pemesanan->kode_pemesanan))
            ->assertRedirect(route('rental.voucher', $pemesanan->kode_pemesanan));

        $this->assertSame('paid', $pemesanan->fresh()->status);
        $this->assertSame('settlement', $pemesanan->pembayaran->fresh()->status_pembayaran);

        $this->get(route('rental.voucher', $pemesanan->kode_pemesanan))
            ->assertOk()
            ->assertSee('LUNAS / VERIFIED')
            ->assertSee('Andi Pratama');
    }

    public function test_expired_payment_cannot_be_confirmed(): void
    {
        $alat = Peralatan::query()->firstOrFail();

        $pemesanan = Pemesanan::query()->create([
            'kode_pemesanan' => 'RJN-2026-0099',
            'nama_ketua' => 'Uji Kedaluwarsa',
            'email_ketua' => 'uji@example.com',
            'telepon_ketua' => '081200000000',
            'nik_ketua' => '5201021908950001',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(2)->toDateString(),
            'total_hari' => 3,
            'total_tagihan' => 50000,
            'status' => 'pending',
        ]);

        $pemesanan->items()->create([
            'peralatan_id' => $alat->id,
            'jumlah' => 1,
            'tarif_per_hari_snapshot' => $alat->tarif_harian,
            'subtotal' => 45000,
        ]);

        Pembayaran::query()->create([
            'pemesanan_id' => $pemesanan->id,
            'referensi_pembayaran' => 'QRIS-RJN-2026-0099',
            'nominal' => 50000,
            'status_pembayaran' => 'pending',
            'kedaluwarsa_pada' => now()->subMinutes(2),
        ]);

        $this->get(route('rental.payment', $pemesanan->kode_pemesanan))
            ->assertOk()
            ->assertSee('Waktu Pembayaran Habis');

        $this->assertSame('expired', $pemesanan->fresh()->status);
        $this->assertSame('expire', $pemesanan->pembayaran->fresh()->status_pembayaran);

        $this->post(route('rental.payment.confirm', $pemesanan->kode_pemesanan))
            ->assertRedirect(route('rental.payment', $pemesanan->kode_pemesanan));

        $this->assertSame('expired', $pemesanan->fresh()->status);

        $this->get(route('rental.voucher', $pemesanan->kode_pemesanan))
            ->assertRedirect(route('rental.payment', $pemesanan->kode_pemesanan));
    }
}
