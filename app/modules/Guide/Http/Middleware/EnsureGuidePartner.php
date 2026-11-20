<?php

namespace Modules\Guide\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Guide\Models\Pemandu;
use Symfony\Component\HttpFoundation\Response;

class EnsureGuidePartner
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        abort_unless(
            $user->peran === 'guide',
            403,
            'Halaman ini khusus untuk mitra pemandu.'
        );

        $pemandu = Pemandu::query()->where('user_id', $user->id)->first();

        abort_if($pemandu === null, 403, 'Akun ini belum terdaftar sebagai pemandu.');

        if ($pemandu->status !== 'active') {
            return redirect()->route('guide.verification');
        }

        return $next($request);
    }
}
