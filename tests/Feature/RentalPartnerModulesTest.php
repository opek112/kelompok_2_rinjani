<?php

namespace Tests\Feature;

use Database\Seeders\RentalCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Booking\Models\Pemesanan;
use Modules\Identity\Models\User;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;
use Tests\TestCase;

class RentalPartnerModulesTest extends TestCase
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

    private function pesananDisewa(): Pemesanan
    {
        $toko = $this->toko();
        $alat = Peralatan::query()->where('toko_rental_id', $toko->id)->firstOrFail();

        $pesanan = Pemesanan::query()->create([
            'kode_pemesanan' => 'RJN-2026-0700',
            'nama_ketua' => 'Budi Hartono',
            'email_ketua' => 'budi@example.com',
            'telepon_ketua' => '081211112222',
            'nik_ketua' => '5201021908950009',
            'tanggal_mulai' => today()->subDays(3)->toDateString(),
            'tanggal_selesai' => today()->subDay()->toDateString(),
            'total_hari' => 3,
            'total_tagihan' => 225000,
            'status' => 'paid',
            'waktu_serah_terima' => now()->subDays(3),
        ]);

        $pesanan->items()->create([
            'peralatan_id' => $alat->id,
            'jumlah' => 2,
            'tarif_per_hari_snapshot' => $alat->tarif_harian,
            'subtotal' => 225000,
        ]);

        return $pesanan;
    }

    public function test_rental_registration_creates_store_for_admin_verification(): void
    {
        Storage::fake('public');

        $this->post(route('register.rental.store'), [
            'nama' => 'Pemilik Toko Uji',
            'email' => 'tokouji@example.com',
            'no_telepon' => '081200001234',
            'password' => 'PasswordUji123',
            'password_confirmation' => 'PasswordUji123',
        ])->assertRedirect(route('register.rental.step2'));

        $this->post(route('register.rental.step2.store'), [
            'nama_toko' => 'Toko Uji Rinjani',
            'lokasi_pos' => 'Senaru',
            'alamat' => 'Jl. Raya Senaru No. 10',
            'deskripsi' => 'Penyewaan alat pendakian di pos Senaru.',
        ])->assertRedirect(route('register.rental.step3'));

        $this->post(route('register.rental.step3.store'), [
            'nib' => '1234567890123',
            'npwp' => '09.876.543.2-911.000',
            'file_legalitas' => UploadedFile::fake()->create('legalitas.pdf', 120, 'application/pdf'),
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'nama_pemilik_rekening' => 'Pemilik Toko Uji',
        ])->assertRedirect(route('rental.verification'));

        $this->assertDatabaseHas('toko_rental', [
            'nama_toko' => 'Toko Uji Rinjani',
            'lokasi_pos' => 'Senaru',
            'nib' => '1234567890123',
            'status' => 'pending',
        ]);

        $tokoBaru = TokoRental::query()->where('nama_toko', 'Toko Uji Rinjani')->firstOrFail();
        $this->assertSame('1234567890', $tokoBaru->nomor_rekening);
        $this->assertNotNull($tokoBaru->path_berkas_legalitas);

        // Toko baru belum boleh masuk dashboard, diarahkan ke halaman cek verifikasi.
        $this->actingAs($tokoBaru->user)->get(route('rental.dashboard'))
            ->assertRedirect(route('rental.verification'));

        // Pendaftaran rental harus masuk daftar verifikasi admin agar bisa disetujui.
        $admin = User::create([
            'nama' => 'Admin Uji',
            'email' => 'adminuji@example.com',
            'no_telepon' => '081200009999',
            'password' => 'password',
            'peran' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin)->get(route('admin.verifikasi'))
            ->assertOk()
            ->assertSee('Toko Uji Rinjani');

        // Admin menyetujui toko, lalu pemiliknya bisa masuk dashboard mitra.
        $this->actingAs($admin)->patch(route('admin.verifikasi.rental.update', $tokoBaru), [
            'status' => 'active',
        ])->assertSessionHasNoErrors();

        $this->assertSame('active', $tokoBaru->fresh()->status);

        $this->actingAs($tokoBaru->user)->get(route('rental.dashboard'))->assertOk();
    }

    public function test_pending_store_cannot_open_partner_modules(): void
    {
        $toko = $this->toko();
        $toko->update(['status' => 'pending']);

        $this->actingAs($toko->user)->get(route('rental.returns'))
            ->assertRedirect(route('rental.verification'));

        $this->actingAs($toko->user)->get(route('rental.settings'))
            ->assertRedirect(route('rental.verification'));
    }

    public function test_return_page_lists_orders_waiting_to_come_back(): void
    {
        $pesanan = $this->pesananDisewa();

        $this->actingAs($this->toko()->user)
            ->get(route('rental.returns'))
            ->assertOk()
            ->assertSee('RJN-2026-0700')
            ->assertSee('Catat Pengembalian');

        $this->actingAs($this->toko()->user)
            ->get(route('rental.returns.show', $pesanan))
            ->assertOk()
            ->assertSee('Kondisi Alat')
            ->assertSee('Checklist Pengembalian');
    }

    public function test_partner_records_return_condition_and_fine(): void
    {
        $pesanan = $this->pesananDisewa();
        $item = $pesanan->items()->firstOrFail();

        $this->actingAs($this->toko()->user)
            ->post(route('rental.returns.store', $pesanan), [
                'items' => [
                    $item->id => ['baik' => 1, 'rusak' => 1, 'hilang' => 0, 'denda' => 75000, 'catatan' => 'Resleting robek'],
                ],
                'catatan' => 'Sudah dikonfirmasi ke pemesan.',
                'checklist' => [1, 2, 3, 4],
            ])
            ->assertRedirect(route('rental.returns.show', $pesanan));

        $pesanan->refresh();

        $this->assertSame('completed', $pesanan->status);
        $this->assertNotNull($pesanan->waktu_pengembalian);
        $this->assertSame(75000.0, (float) $pesanan->denda_total);
        $this->assertSame('Sudah dikonfirmasi ke pemesan.', $pesanan->catatan_pengembalian);

        $this->assertDatabaseHas('pengembalian_peralatan', [
            'item_pemesanan_id' => $item->id,
            'jumlah_baik' => 1,
            'jumlah_rusak' => 1,
            'jumlah_hilang' => 0,
        ]);

        $this->actingAs($this->toko()->user)
            ->get(route('rental.returns.show', $pesanan))
            ->assertOk()
            ->assertSee('Pengembalian Berhasil Dicatat')
            ->assertSee('Rp 75.000');
    }

    public function test_return_condition_cannot_exceed_rented_quantity(): void
    {
        $pesanan = $this->pesananDisewa();
        $item = $pesanan->items()->firstOrFail();

        $this->actingAs($this->toko()->user)
            ->from(route('rental.returns.show', $pesanan))
            ->post(route('rental.returns.store', $pesanan), [
                'items' => [
                    $item->id => ['baik' => 5, 'rusak' => 0, 'hilang' => 0],
                ],
                'checklist' => [1, 2, 3, 4],
            ])
            ->assertRedirect(route('rental.returns.show', $pesanan))
            ->assertSessionHasErrors('items');

        $this->assertSame('paid', $pesanan->fresh()->status);
        $this->assertNull($pesanan->fresh()->waktu_pengembalian);
    }

    public function test_partner_cannot_open_return_of_another_store(): void
    {
        $alatTokoLain = Peralatan::query()->where('nama', 'Carrier 60L')->firstOrFail();

        $pesanan = Pemesanan::query()->create([
            'kode_pemesanan' => 'RJN-2026-0701',
            'nama_ketua' => 'Pesanan Toko Lain',
            'email_ketua' => 'lain@example.com',
            'telepon_ketua' => '081200000010',
            'nik_ketua' => '5201021908950010',
            'tanggal_mulai' => today()->subDays(2)->toDateString(),
            'tanggal_selesai' => today()->toDateString(),
            'total_hari' => 2,
            'total_tagihan' => 100000,
            'status' => 'paid',
            'waktu_serah_terima' => now()->subDays(2),
        ]);

        $pesanan->items()->create([
            'peralatan_id' => $alatTokoLain->id,
            'jumlah' => 1,
            'tarif_per_hari_snapshot' => $alatTokoLain->tarif_harian,
            'subtotal' => 100000,
        ]);

        $this->actingAs($this->toko()->user)
            ->get(route('rental.returns.show', $pesanan))
            ->assertNotFound();
    }

    public function test_settings_tabs_are_accessible(): void
    {
        $user = $this->toko()->user;

        foreach (['legalitas', 'rekening', 'keamanan', 'preferensi'] as $tab) {
            $this->actingAs($user)
                ->get(route('rental.settings', ['tab' => $tab]))
                ->assertOk();
        }

        $this->actingAs($user)
            ->get(route('rental.settings', ['tab' => 'preferensi']))
            ->assertSee('Preferensi Notifikasi')
            ->assertSee('Jam Operasional');
    }

    public function test_partner_updates_store_settings(): void
    {
        $toko = $this->toko();
        $user = $toko->user;

        $this->actingAs($user)->post(route('rental.settings.rekening'), [
            'nama_bank' => 'BRI',
            'nomor_rekening' => '9876543210',
            'nama_pemilik_rekening' => 'Hadi Santoso',
        ])->assertRedirect(route('rental.settings', ['tab' => 'rekening']));

        $this->assertSame('BRI', $toko->fresh()->nama_bank);
        $this->assertSame('9876543210', $toko->fresh()->nomor_rekening);

        $this->actingAs($user)->post(route('rental.settings.notifikasi'), [
            'pesanan_baru' => '1',
            'pengembalian_terlambat' => '1',
        ])->assertRedirect(route('rental.settings', ['tab' => 'preferensi']));

        $notifikasi = $toko->fresh()->notifikasi;
        $this->assertTrue($notifikasi['pesanan_baru']);
        $this->assertFalse($notifikasi['promo']);

        $this->actingAs($user)->post(route('rental.settings.operasional'), [
            'batas_stok_minimum' => 4,
            'hari_buka' => 'Setiap hari',
            'jam_buka' => '07:00',
            'jam_tutup' => '21:00',
            'auto_tutup_kosong' => '1',
            'tutup_hari_libur' => '1',
        ])->assertRedirect(route('rental.settings', ['tab' => 'preferensi']));

        $this->assertSame(4, (int) $toko->fresh()->batas_stok_minimum);
        $this->assertSame('21:00', $toko->fresh()->jam_tutup);

        $this->actingAs($user)->post(route('rental.settings.aktif'))
            ->assertRedirect(route('rental.settings', ['tab' => 'keamanan']));

        $this->assertFalse($toko->fresh()->aktif);
    }

    public function test_partner_can_change_password(): void
    {
        $user = $this->toko()->user;

        $this->actingAs($user)->post(route('rental.settings.keamanan'), [
            'password_lama' => 'password',
            'password' => 'SandiBaruRinjani2026',
            'password_confirmation' => 'SandiBaruRinjani2026',
        ])->assertRedirect(route('rental.settings', ['tab' => 'keamanan']));

        $this->assertTrue(password_verify('SandiBaruRinjani2026', $user->fresh()->password));
    }
}
