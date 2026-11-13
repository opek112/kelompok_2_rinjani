<?php

namespace Modules\Payment\Providers;

use Modules\Shared\Providers\ModuleServiceProvider;

class PaymentServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Payment'; }
    protected function viewNamespace(): string { return 'Payment'; }
}
