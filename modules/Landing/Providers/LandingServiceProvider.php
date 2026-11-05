<?php

namespace Modules\Landing\Providers;

use Modules\Shared\Providers\ModuleServiceProvider;

class LandingServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Landing'; }
    protected function viewNamespace(): string { return 'Landing'; }
}
