<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockRentalFromCustomer
{
    /**
     * Mitra toko rental tidak boleh masuk ke halaman milik pendaki (customer).
     * Mereka diarahkan ke dashboard rental, atau ke halaman cek verifikasi
     * selama tokonya belum disetujui admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user !== null && $user->peran === 'rental') {
            $toko = $user->tokoRental()->first();

            if ($toko !== null && $toko->status === 'active') {
                return redirect()->route('rental.dashboard');
            }

            return redirect()->route('rental.verification');
        }

        return $next($request);
    }
}
