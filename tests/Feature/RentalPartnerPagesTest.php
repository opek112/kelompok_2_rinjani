<?php

namespace Tests\Feature;

use Database\Seeders\RentalCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Booking\Models\Pemesanan;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;
use Modules\Rental\Support\StokService;
use Tests\TestCase;

class RentalPartnerPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RentalCatalogSeeder::class);
    }

    private function toko(): TokoRental
    {
        return TokoRental::query()->where('nama_toko', 'Rinjani Outdoor')->firstOrFail();
    }

    public function test_partner_profile_page_can_be_opened_and_updated(): void
    {
        $toko = $this->toko();

        $this->actingAs($toko->user)
            ->get(route('rental.profile'))
            ->assertOk()
            ->assertSee('Profil Toko')
            ->assertSee('Jam Operasional Toko');

        $this->actingAs($toko->user)->post(route('rental.profile.update'), [
            'nama_toko' => 'Rinjani Outdoor Baru',
            'penanggung_jawab' => 'Hadi Santoso',
            'telepon_toko' => '081900001111',
            'lokasi_pos' => 'Senaru',
            'alamat' => 'Jl. Raya Senaru No. 4',
            'deskripsi' => 'Toko rental alat pendakian di pos Senaru.',
            'hari_buka' => 'Setiap hari',
            'jam_buka' => '07:00',
            'jam_tutup' => '21:00',
        ])->assertRedirect(route('rental.profile'));

        $toko->refresh();
        $this->assertSame('Rinjani Outdoor Baru', $toko->nama_toko);
        $this->assertSame('Senaru', $toko->lokasi_pos);
        $this->assertSame('21:00', $toko->jam_tutup);
    }

    public function test_partner_report_page_and_export_are_available(): void
    {
        $toko = $this->toko();

        $this->actingAs($toko->user)
            ->get(route('rental.reports'))
            ->assertOk()
            ->assertSee('Rekap Pendapatan')
            ->assertSee('Mutasi Inventaris')
            ->assertSee('Riwayat Pendapatan');

        $unduhan = $this->actingAs($toko->user)->get(route('rental.reports.export'));
        $unduhan->assertOk();
        $this->assertStringContainsString('text/csv', (string) $unduhan->headers->get('content-type'));
    }

    public function test_partner_report_shows_inventory_mutation_for_returned_item(): void
    {
        $toko = $this->toko();
        $alat = Peralatan::query()->where('toko_rental_id', $toko->id)->firstOrFail();

        $pesanan = Pemesanan::query()->create([
            'kode_pemesanan' => 'RJN-2026-0801',
            'nama_ketua' => 'Pemesan Rekap',
            'email_ketua' => 'rekap@example.com',
            'telepon_ketua' => '081200000321',
            'nik_ketua' => '5201021908950022',
            'tanggal_mulai' => today()->toDateString(),
            'tanggal_selesai' => today()->toDateString(),
            'total_hari' => 1,
            'total_tagihan' => 200000,
            'status' => 'completed',
            'waktu_serah_terima' => now()->subDay(),
            'waktu_pengembalian' => now(),
        ]);

        $item = $pesanan->items()->create([
            'peralatan_id' => $alat->id,
            'jumlah' => 2,
            'tarif_per_hari_snapshot' => $alat->tarif_harian,
            'subtotal' => 200000,
        ]);

        $item->pengembalian()->create([
            'jumlah_baik' => 1,
            'jumlah_rusak' => 1,
            'jumlah_hilang' => 0,
            'denda' => 25000,
        ]);

        $this->actingAs($toko->user)
            ->get(route('rental.reports'))
            ->assertOk()
            ->assertSee('RJN-2026-0801')
            ->assertSee('Dikembalikan — Kondisi Baik')
            ->assertSee('Dikembalikan — Perlu Perbaikan');
    }

    public function test_partner_notification_page_lists_and_marks_notifications(): void
    {
        $toko = $this->toko();

        $this->actingAs($toko->user)
            ->get(route('rental.notifications'))
            ->assertOk()
            ->assertSee('Notifikasi')
            ->assertSee('Tandai Semua Dibaca');

        $this->actingAs($toko->user)
            ->post(route('rental.notifications.baca-semua'))
            ->assertRedirect();

        $this->assertNotEmpty($toko->fresh()->notifikasi_dibaca);
    }

    public function test_bell_opens_notification_page_instead_of_orders(): void
    {
        $toko = $this->toko();

        $this->actingAs($toko->user)
            ->get(route('rental.dashboard'))
            ->assertOk()
            ->assertSee(route('rental.notifications'), false);
    }

    public function test_partner_catalog_page_shows_items_and_remaining_stock(): void
    {
        $toko = $this->toko();
        $alat = Peralatan::query()->where('toko_rental_id', $toko->id)->firstOrFail();

        $this->actingAs($toko->user)
            ->get(route('rental.catalog'))
            ->assertOk()
            ->assertSee('Katalog Barang Sewa')
            ->assertSee($alat->nama)
            ->assertSee('Sisa');
    }

    public function test_stok_service_subtracts_overlapping_paid_orders(): void
    {
        $toko = $this->toko();
        $alat = Peralatan::query()->where('toko_rental_id', $toko->id)->firstOrFail();

        $pesanan = Pemesanan::query()->create([
            'kode_pemesanan' => 'RJN-2026-0800',
            'nama_ketua' => 'Uji Stok',
            'email_ketua' => 'stok@example.com',
            'telepon_ketua' => '081200000123',
            'nik_ketua' => '5201021908950021',
            'tanggal_mulai' => today()->toDateString(),
            'tanggal_selesai' => today()->addDays(2)->toDateString(),
            'total_hari' => 3,
            'total_tagihan' => 100000,
            'status' => 'paid',
        ]);

        $pesanan->items()->create([
            'peralatan_id' => $alat->id,
            'jumlah' => 2,
            'tarif_per_hari_snapshot' => $alat->tarif_harian,
            'subtotal' => 100000,
        ]);

        $service = new StokService;

        $this->assertSame($alat->jumlah_stok - 2, $service->sisaStok($alat->id, today(), today()->addDay()));

        // Tanggal yang tidak beririsan tidak memotong stok.
        $this->assertSame($alat->jumlah_stok, $service->sisaStok($alat->id, today()->addDays(10), today()->addDays(12)));
    }
}
