<?php

namespace Modules\Rental\Support;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Booking\Models\ItemPemesanan;
use Modules\Rental\Models\Peralatan;

/**
 * FR-REN-03 — perhitungan stok tersedia pada rentang tanggal tertentu.
 *
 * jumlah_stok dikurangi total jumlah pada pesanan beririsan yang berstatus
 * paid, atau pending yang belum melewati batas kedaluwarsa pembayaran.
 */
class StokService
{
    public function sisaStok(int $idPeralatan, CarbonInterface|string $mulai, CarbonInterface|string $selesai): int
    {
        $jumlahStok = (int) Peralatan::query()->whereKey($idPeralatan)->value('jumlah_stok');

        return max(0, $jumlahStok - $this->terpakai($idPeralatan, $mulai, $selesai));
    }

    public function terpakai(int $idPeralatan, CarbonInterface|string $mulai, CarbonInterface|string $selesai): int
    {
        return (int) ItemPemesanan::query()
            ->where('peralatan_id', $idPeralatan)
            ->whereHas('pemesanan', fn (Builder $query) => $this->pesananAktif($query, $mulai, $selesai))
            ->sum('jumlah');
    }

    /**
     * Sisa stok untuk banyak alat sekaligus (hindari query per kartu).
     *
     * @param  array<int, int>  $idPeralatan
     * @return array<int, int>
     */
    public function petaSisaStok(array $idPeralatan, CarbonInterface|string $mulai, CarbonInterface|string $selesai): array
    {
        $id = array_values(array_unique(array_map('intval', $idPeralatan)));

        if ($id === []) {
            return [];
        }

        $stok = Peralatan::query()->whereIn('id', $id)->pluck('jumlah_stok', 'id');

        $terpakai = ItemPemesanan::query()
            ->selectRaw('peralatan_id, SUM(jumlah) as total')
            ->whereIn('peralatan_id', $id)
            ->whereHas('pemesanan', fn (Builder $query) => $this->pesananAktif($query, $mulai, $selesai))
            ->groupBy('peralatan_id')
            ->pluck('total', 'peralatan_id');

        $hasil = [];

        foreach ($id as $kunci) {
            $hasil[$kunci] = max(0, (int) $stok->get($kunci, 0) - (int) $terpakai->get($kunci, 0));
        }

        return $hasil;
    }

    private function pesananAktif(Builder $query, CarbonInterface|string $mulai, CarbonInterface|string $selesai): Builder
    {
        $awal = Carbon::parse($mulai)->startOfDay();
        $akhir = Carbon::parse($selesai)->startOfDay();

        return $query
            ->whereIn('status', ['paid', 'pending'])
            ->whereDate('tanggal_mulai', '<=', $akhir)
            ->whereDate('tanggal_selesai', '>=', $awal)
            ->where(function (Builder $builder): void {
                $builder->where('status', 'paid')
                    ->orWhere(function (Builder $pending): void {
                        $pending->where('status', 'pending')
                            ->whereDoesntHave('pembayaran', fn (Builder $bayar) => $bayar
                                ->whereNotNull('kedaluwarsa_pada')
                                ->where('kedaluwarsa_pada', '<=', now()));
                    });
            });
    }
}
