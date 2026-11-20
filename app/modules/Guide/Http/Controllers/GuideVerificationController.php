<?php

namespace Modules\Guide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Guide\Models\Pemandu;

class GuideVerificationController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        abort_if($user === null || $user->peran !== 'guide', 403, 'Halaman ini khusus untuk mitra pemandu.');

        $pemandu = Pemandu::query()->where('user_id', $user->id)->firstOrFail();

        if ($pemandu->status === 'active') {
            return redirect()->route('guide.dashboard');
        }

        return view('guide.verification', compact('pemandu'));
    }
}
