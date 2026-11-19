<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Akun rental yang terdaftar sebelum perbaikan pendaftaran tidak memiliki
     * baris toko_rental, sehingga tidak muncul di verifikasi admin dan tidak
     * bisa mengakses dashboard. Buatkan data toko berstatus pending agar dapat
     * ditinjau admin.
     */
    public function up(): void
    {
        $tanpaToko = DB::table('users')
            ->where('peran', 'rental')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('toko_rental')
                    ->whereColumn('toko_rental.user_id', 'users.id');
            })
            ->get(['id', 'nama', 'no_telepon', 'created_at']);

        foreach ($tanpaToko as $user) {
            DB::table('toko_rental')->insert([
                'user_id' => $user->id,
                'nama_toko' => $user->nama,
                'penanggung_jawab' => $user->nama,
                'telepon_toko' => $user->no_telepon,
                'status' => 'pending',
                'created_at' => $user->created_at ?? now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Data toko yang sudah diisi pengguna tidak dihapus saat rollback.
    }
};
