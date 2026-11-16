<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Http\Controllers\PaymentWebhookController;

Route::post('/webhook/midtrans', [PaymentWebhookController::class, 'handle'])->name('webhook.midtrans');