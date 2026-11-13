<?php

namespace Modules\Admin\Providers;

use Modules\Shared\Providers\ModuleServiceProvider;

class AdminServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Admin'; }
    protected function viewNamespace(): string { return 'Admin'; }
}
