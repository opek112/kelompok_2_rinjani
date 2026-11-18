<?php

namespace Modules\Guide\Policies;

use Modules\Booking\Models\Pemesanan;
use Modules\Identity\Models\User;

class PemesananPolicy
{
    /**
     * Pemandu hanya boleh melihat penugasan miliknya, admin boleh semua.
     */
    public function view(User $user, Pemesanan $pemesanan): bool
    {
        if ($user->peran === 'admin') {
            return true;
        }

        return $pemesanan->pemandu !== null
            && (int) $pemesanan->pemandu->user_id === (int) $user->id;
    }

    /**
     * Akses berkas KTP pemesan mengikuti hak akses penugasan.
     */
    public function viewKtp(User $user, Pemesanan $pemesanan): bool
    {
        return $this->view($user, $pemesanan);
    }
}
