<?php

namespace Modules\Guide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Guide\Models\Pemandu;

abstract class GuideController extends Controller
{
    protected function pemandu(): Pemandu
    {
        $pemandu = Pemandu::query()->where('user_id', Auth::id())->first();

        abort_if($pemandu === null, 403, 'Akun ini belum terdaftar sebagai pemandu.');

        return $pemandu;
    }
}
