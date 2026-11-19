<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Admin\Models\PengaturanPlatform;

class AdminConfigurationController extends Controller
{
    public function index(): View
    {
        $nilaiPengaturan = PengaturanPlatform::query()
            ->whereIn('kunci', ['nama_platform', 'email_formal', 'nomor_whatsapp'])
            ->pluck('nilai', 'kunci');
        $namaPlatform = $nilaiPengaturan->get('nama_platform')
            ?? config('app.name');
        $emailFormal = $nilaiPengaturan->get('email_formal')
            ?? config('mail.from.address');
        $nomorWhatsapp = $nilaiPengaturan->get('nomor_whatsapp');
        $modePemeliharaan = app()->isDownForMaintenance();
        $bahasa = config('app.locale');
        $zonaWaktu = config('app.timezone');

        return view('admin::pengaturan', compact(
            'namaPlatform',
            'emailFormal',
            'nomorWhatsapp',
            'modePemeliharaan',
            'bahasa',
            'zonaWaktu'
        ));
    }

    public function security(Request $request): View
    {
        $alamatIp = $request->ip();
        $perangkat = $request->userAgent() ?: 'Informasi perangkat tidak tersedia';

        return view('admin::keamanan', compact('alamatIp', 'perangkat'));
    }

    public function integrations(): View
    {
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');
        $midtransConfigured = is_string($serverKey)
            && $serverKey !== ''
            && ! str_starts_with($serverKey, 'DUMMY_');
        $clientKeyConfigured = is_string($clientKey)
            && $clientKey !== ''
            && ! str_starts_with($clientKey, 'DUMMY_');
        $modeMidtrans = config('midtrans.is_production') ? 'PRODUCTION' : 'SANDBOX';
        $webhookUrl = route('webhook.midtrans');
        $mailDriver = config('mail.default');

        return view('admin::integrasi', compact(
            'midtransConfigured',
            'clientKeyConfigured',
            'modeMidtrans',
            'webhookUrl',
            'mailDriver'
        ));
    }

    public function notificationSettings(): View
    {
        $mailDriver = config('mail.default');

        return view('admin::notifikasi-pengaturan', compact('mailDriver'));
    }
}
