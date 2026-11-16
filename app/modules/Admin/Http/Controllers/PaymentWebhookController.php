<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payment\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        // Validasi signature menggunakan Service
        $isValid = $this->midtrans->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey);

        if (!$isValid) {
            Log::warning('Webhook Gagal: Signature tidak valid', ['payload' => $payload]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Log::info('Webhook Masuk: Signature Valid', ['order_id' => $orderId]);

        // TODO (A11): Proses pelunasan pemesanan
        
        return response()->json(['message' => 'Webhook berhasil diproses']);
    }
}