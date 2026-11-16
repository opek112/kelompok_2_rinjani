<?php

namespace App\Modules\Payment\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production');
        $this->baseUrl = $this->isProduction 
            ? 'https://api.midtrans.com/v2' 
            : 'https://api.sandbox.midtrans.com/v2';
    }

    /**
     * Membuat transaksi QRIS via Midtrans Core API
     * 
     * @param string $orderId ID unik pesanan (misal: RJN-2026-0001)
     * @param int $grossAmount Total tagihan dalam Rupiah (tanpa desimal)
     * @return array Response dari Midtrans
     */
    public function createQris(string $orderId, int $grossAmount): array
    {
        $payload = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'qris' => [
                'acquirer' => 'gopay', // Bisa diganti sesuai kebutuhan
            ],
        ];

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders(['Accept' => 'application/json'])
                ->post($this->baseUrl . '/charge', $payload);

            if ($response->failed()) {
                Log::error('Midtrans QRIS Error: ' . $response->body());
                return ['error' => true, 'message' => $response->json('status_message')];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Memverifikasi signature key dari webhook Midtrans
     * 
     * @param string $orderId
     * @param string $statusCode
     * @param string $grossAmount
     * @param string $signatureKey Dari payload webhook
     * @return bool
     */
    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);
        return hash_equals($expectedSignature, $signatureKey);
    }

    /**
     * Cek status transaksi ke Midtrans (opsional)
     */
    public function getTransactionStatus(string $orderId): array
    {
        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->get($this->baseUrl . '/' . $orderId . '/status');

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}