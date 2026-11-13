<?php

namespace Modules\Rental\Providers;

use Modules\Shared\Providers\ModuleServiceProvider;

class RentalServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Rental'; }
    protected function viewNamespace(): string { return 'Rental'; }
}
