<?php

namespace Modules\Guide\Providers;

use Modules\Shared\Providers\ModuleServiceProvider;

class GuideServiceProvider extends ModuleServiceProvider
{
    protected function moduleName(): string { return 'Guide'; }
    protected function viewNamespace(): string { return 'Guide'; }
}
