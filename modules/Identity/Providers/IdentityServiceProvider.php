<?php

namespace Modules\Identity\Providers;

use Modules\Shared\Providers\ModuleServiceProvider;

class IdentityServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Identity'; }
    protected function viewNamespace(): string { return 'Identity'; }
}
