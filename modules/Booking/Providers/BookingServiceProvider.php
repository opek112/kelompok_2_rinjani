<?php

namespace Modules\Booking\Providers;

use Modules\Shared\Providers\ModuleServiceProvider;

class BookingServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Booking'; }
    protected function viewNamespace(): string { return 'Booking'; }
}
