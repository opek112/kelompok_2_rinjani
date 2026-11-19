<?php

namespace Modules\Rental\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRentalPartner
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        abort_unless(
            $user->peran === 'rental',
            403,
            'Halaman ini khusus untuk mitra toko rental.'
        );

        $toko = $user->tokoRental()->first();

        if ($toko === null || $toko->status !== 'active') {
            return redirect()->route('rental.verification');
        }

        return $next($request);
    }
}
