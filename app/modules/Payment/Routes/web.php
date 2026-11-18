<?php

use Modules\Admin\Http\Controllers\PaymentWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/midtrans', [PaymentWebhookController::class, 'handle'])->name('webhook.midtrans');
