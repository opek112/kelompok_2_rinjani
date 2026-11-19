<?php

namespace Tests\Feature;

use Database\Seeders\RentalCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Booking\Models\Pemesanan;
use Modules\Identity\Models\User;
use Modules\Rental\Models\Peralatan;
use Modules\Rental\Models\TokoRental;
use Tests\TestCase;

class RentalPartnerDashboardTest extends TestCase
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

    public function test_rental_partner_is_redirected_away_from_customer_homepage(): void
    {
        $this->actingAs($this->toko()->user)
            ->get(route('home'))
            ->assertRedirect(route('rental.dashboard'));

        $this->actingAs($this->toko()->user)
            ->get(route('dashboard'))
            ->assertRedirect(route('rental.dashboard'));
    }

    public function test_customer_still_can_open_customer_homepage(): void
    {
        $customer = User::create([
            'nama' => 'Pendaki Biasa',
            'email' => 'pendaki@example.com',
            'no_telepon' => '081200000001',
            'password' => 'password',
            'peran' => 'customer',
        ]);

        $this->actingAs($customer)->get(route('home'))->assertOk();
    }

    public function test_login_redirects_rental_partner_to_their_dashboard(): void
    {
        $user = $this->toko()->user;

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('rental.dashboard'));

        $this->assertAuthenticatedAs($user->fresh());
    }

    public function test_pending_partner_is_guided_to_verification_status_page(): void
    {
        $toko = $this->toko();
        $toko->update(['status' => 'pending']);

        $this->actingAs($toko->user)
            ->get(route('rental.dashboard'))
            ->assertRedirect(route('rental.verification'));

        $this->actingAs($toko->user)
            ->get(route('rental.verification'))
            ->assertOk()
            ->assertSee('Pendaftaran sedang ditinjau')
            ->assertSee('Cek Status Verifikasi');
    }

    public function test_dashboard_only_lists_inventory_of_the_logged_in_store(): void
    {
        $this->actingAs($this->toko()->user)
            ->get(route('rental.dashboard'))
            ->assertOk()
            ->assertSee('Tenda Dome 4P')
            ->assertDontSee('Carrier 60L');
    }

    public function test_partner_can_create_update_and_delete_equipment(): void
    {
        $user = $this->toko()->user;

        $this->actingAs($user)->post(route('rental.equipment.store'), [
            'nama' => 'Hammock Camping',
            'kategori' => 'Aksesoris',
            'pos' => 'Sembalun',
            'tarif_harian' => 12000,
            'jumlah_stok' => 4,
            'deskripsi' => 'Hammock ringan dengan tali penyangga.',
        ])->assertRedirect(route('rental.dashboard'));

        $alat = Peralatan::query()->where('nama', 'Hammock Camping')->firstOrFail();
        $this->assertSame($this->toko()->id, $alat->toko_rental_id);
        $this->assertSame(4, $alat->jumlah_stok);

        $this->actingAs($user)->put(route('rental.equipment.update', $alat), [
            'nama' => 'Hammock Camping Pro',
            'kategori' => 'Aksesoris',
            'pos' => 'Sembalun',
            'tarif_harian' => 15000,
            'jumlah_stok' => 6,
        ])->assertRedirect(route('rental.dashboard'));

        $this->assertSame(6, $alat->fresh()->jumlah_stok);
        $this->assertSame('Hammock Camping Pro', $alat->fresh()->nama);

        $this->actingAs($user)->delete(route('rental.equipment.destroy', $alat))
            ->assertRedirect(route('rental.dashboard'));

        $this->assertNull($alat->fresh());
    }

    public function test_partner_cannot_edit_equipment_of_another_store(): void
    {
        $alatTokoLain = Peralatan::query()->where('nama', 'Carrier 60L')->firstOrFail();

        $this->actingAs($this->toko()->user)
            ->get(route('rental.equipment.edit', $alatTokoLain))
            ->assertNotFound();
    }

    public function test_partner_can_record_delivery_then_return(): void
    {
        $toko = $this->toko();
        $alat = Peralatan::query()->where('toko_rental_id', $toko->id)->firstOrFail();

        $pesanan = Pemesanan::query()->create([
            'kode_pemesanan' => 'RJN-2026-0500',
            'nama_ketua' => 'Uji Mitra',
            'email_ketua' => 'mitra@example.com',
            'telepon_ketua' => '081277778888',
            'nik_ketua' => '5201021908950001',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(2)->toDateString(),
            'total_hari' => 3,
            'total_tagihan' => 135000,
            'status' => 'paid',
        ]);

        $pesanan->items()->create([
            'peralatan_id' => $alat->id,
            'jumlah' => 1,
            'tarif_per_hari_snapshot' => $alat->tarif_harian,
            'subtotal' => 135000,
        ]);

        $this->actingAs($toko->user)
            ->get(route('rental.orders'))
            ->assertOk()
            ->assertSee('RJN-2026-0500')
            ->assertSee('Konfirmasi Serah Terima');

        $this->actingAs($toko->user)
            ->post(route('rental.orders.deliver', $pesanan))
            ->assertSessionHasNoErrors();

        $this->assertNotNull($pesanan->fresh()->waktu_serah_terima);

        $this->actingAs($toko->user)
            ->get(route('rental.orders', ['tab' => 'disewa']))
            ->assertOk()
            ->assertSee('RJN-2026-0500')
            ->assertSee('Catat Pengembalian');

        $this->actingAs($toko->user)
            ->post(route('rental.orders.complete', $pesanan))
            ->assertSessionHasNoErrors();

        $this->assertSame('completed', $pesanan->fresh()->status);
    }

    public function test_partner_cannot_update_order_of_another_store(): void
    {
        $alatTokoLain = Peralatan::query()->where('nama', 'Carrier 60L')->firstOrFail();

        $pesanan = Pemesanan::query()->create([
            'kode_pemesanan' => 'RJN-2026-0501',
            'nama_ketua' => 'Pesanan Toko Lain',
            'email_ketua' => 'lain@example.com',
            'telepon_ketua' => '081200000009',
            'nik_ketua' => '5201021908950002',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(1)->toDateString(),
            'total_hari' => 2,
            'total_tagihan' => 100000,
            'status' => 'paid',
        ]);

        $pesanan->items()->create([
            'peralatan_id' => $alatTokoLain->id,
            'jumlah' => 1,
            'tarif_per_hari_snapshot' => $alatTokoLain->tarif_harian,
            'subtotal' => 100000,
        ]);

        $this->actingAs($this->toko()->user)
            ->post(route('rental.orders.deliver', $pesanan))
            ->assertNotFound();

        $this->assertNull($pesanan->fresh()->waktu_serah_terima);
    }

    public function test_inventory_export_downloads_csv_for_the_store(): void
    {
        $response = $this->actingAs($this->toko()->user)->get(route('rental.inventory.export'));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
