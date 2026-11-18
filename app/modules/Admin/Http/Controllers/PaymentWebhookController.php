<?php

namespace Modules\Admin\Http\Controllers; // <-- Pastikan pakai Modules

use App\Http\Controllers\Controller;
use Modules\Payment\Services\MidtransService; // <-- Pakai Modules\Payment
use Modules\Admin\Services\PemesananService; // <-- PASTIKAN INI ADA
use Modules\Payment\Models\Pembayaran; // <-- Pakai Modules\Payment
use Modules\Payment\Models\LogPembayaran; // <-- Pakai Modules\Payment
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class PaymentWebhookController extends Controller
{
    protected MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    public function handle(Request $request)
    {
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;

        // 1. Validasi Signature
        $isValid = $this->midtrans->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey);

        if (!$isValid) {
            Log::warning('Webhook Gagal: Signature tidak valid', ['payload' => $payload]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Log::info('Webhook Masuk: Signature Valid', ['order_id' => $orderId]);

        // 2. Cari data Pembayaran berdasarkan referensi (order_id Midtrans)
        $pembayaran = Pembayaran::where('referensi_pembayaran', $orderId)->first();

        if (!$pembayaran) {
            Log::warning('Webhook Gagal: Pembayaran tidak ditemukan', ['order_id' => $orderId]);
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }

        // 3. Cek Idempotensi (Mencegah pemrosesan ganda)
        // Jika status di database sudah sama dengan status dari Midtrans, abaikan.
        if ($pembayaran->status_pembayaran === $transactionStatus) {
            return response()->json(['message' => 'Webhook sudah diproses sebelumnya (Idempoten)']);
        }

        // 4. Simpan Log Mentah ke database
        LogPembayaran::create([
            'pembayaran_id' => $pembayaran->id,
            'payload_mentah' => json_encode($payload),
            'tanda_tangan_valid' => true,
        ]);

        // 5. Update Status Pembayaran
        DB::transaction(function () use ($pembayaran, $transactionStatus, $payload) {
            $status = 'pending';
            
         if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
    $status = 'settlement';
    $pembayaran->dibayar_pada = now();
    
    // PANGGIL SERVICE
    $pemesananService = new PemesananService();
    $pemesananService->tandaiLunas($pembayaran);
    
} elseif ($transactionStatus === 'expire') {
                $status = 'expire';
            } elseif ($transactionStatus === 'deny' || $transactionStatus === 'cancel' || $transactionStatus === 'failure') {
                $status = 'failure';
            }

            $pembayaran->update([
                'status_pembayaran' => $status,
            ]);
        });

        return response()->json(['message' => 'Webhook berhasil diproses']);
    }
}