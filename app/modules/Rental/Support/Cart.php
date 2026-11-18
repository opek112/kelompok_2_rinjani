<?php

namespace Modules\Rental\Support;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Rental\Models\Peralatan;

class Cart
{
    public const SESSION_KEY = 'rental_cart';

    public const BIAYA_LAYANAN = 5000;

    public function __construct(private readonly Request $request) {}

    public function isEmpty(): bool
    {
        return $this->jumlahItem() === 0;
    }

    public function jumlahItem(): int
    {
        return array_sum($this->state()['items']);
    }

    /**
     * @return array{items: array<int, int>, tanggal_mulai: string, tanggal_selesai: string}
     */
    public function state(): array
    {
        $state = $this->request->session()->get(self::SESSION_KEY, []);

        return [
            'items' => $state['items'] ?? [],
            'tanggal_mulai' => $state['tanggal_mulai'] ?? now()->addDay()->toDateString(),
            'tanggal_selesai' => $state['tanggal_selesai'] ?? now()->addDays(3)->toDateString(),
        ];
    }

    /**
     * @return Collection<int, array{peralatan: Peralatan, jumlah: int, subtotal: float}>
     */
    public function items(): Collection
    {
        $state = $this->state();

        if ($state['items'] === []) {
            return collect();
        }

        $peralatan = Peralatan::query()
            ->with('toko')
            ->whereIn('id', array_keys($state['items']))
            ->get()
            ->keyBy('id');

        return collect($state['items'])
            ->filter(fn (int $jumlah, int $id): bool => $peralatan->has($id))
            ->map(function (int $jumlah, int $id) use ($peralatan): array {
                $item = $peralatan->get($id);

                return [
                    'peralatan' => $item,
                    'jumlah' => $jumlah,
                    'subtotal' => $item->tarif_harian * $jumlah * $this->durasiHari(),
                ];
            })
            ->values();
    }

    public function tambah(Peralatan $peralatan, int $jumlah): void
    {
        $state = $this->state();
        $sebelumnya = $state['items'][$peralatan->id] ?? 0;

        $state['items'][$peralatan->id] = min(
            max(1, $sebelumnya + $jumlah),
            max(1, $peralatan->jumlah_stok),
        );

        $this->request->session()->put(self::SESSION_KEY, $state);
    }

    public function ubahJumlah(Peralatan $peralatan, int $jumlah): void
    {
        $state = $this->state();

        if (! isset($state['items'][$peralatan->id])) {
            return;
        }

        $state['items'][$peralatan->id] = max(1, min($jumlah, max(1, $peralatan->jumlah_stok)));

        $this->request->session()->put(self::SESSION_KEY, $state);
    }

    public function hapus(int $peralatanId): void
    {
        $state = $this->state();
        unset($state['items'][$peralatanId]);

        $this->request->session()->put(self::SESSION_KEY, $state);
    }

    public function aturTanggal(string $mulai, string $selesai): void
    {
        $state = $this->state();
        $state['tanggal_mulai'] = $mulai;
        $state['tanggal_selesai'] = $selesai;

        $this->request->session()->put(self::SESSION_KEY, $state);
    }

    public function mulai(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->state()['tanggal_mulai'])->startOfDay();
    }

    public function selesai(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->state()['tanggal_selesai'])->startOfDay();
    }

    public function durasiHari(): int
    {
        $selisih = $this->mulai()->diffInDays($this->selesai());

        return max(1, (int) $selisih + 1);
    }

    public function subtotal(): float
    {
        return (float) $this->items()->sum('subtotal');
    }

    public function biayaLayanan(): float
    {
        return $this->isEmpty() ? 0.0 : (float) self::BIAYA_LAYANAN;
    }

    public function total(): float
    {
        return $this->subtotal() + $this->biayaLayanan();
    }

    public function kosongkan(): void
    {
        $this->request->session()->forget(self::SESSION_KEY);
    }
}
